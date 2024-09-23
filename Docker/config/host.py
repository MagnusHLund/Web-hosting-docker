import os
import sys
import json
import signal
import datetime
import subprocess
import netifaces as ni

def load_projects():
    """Load the project details from the JSON file."""
    # Open the JSON file in read mode
    with open('/app/config/projects.json', 'r') as json_file:
        # Parse the JSON file and return the result
        return json.load(json_file)

def check_ports(projects):
    """Check if multiple projects are using the same port."""
    try:
        # Create a list of all the ports used by the projects
        ports = [project['port'] for project in projects]
        # If the number of unique ports is less than the total number of ports,
        # it means that multiple projects are using the same port
        if len(ports) != len(set(ports)):
            raise ValueError("Multiple projects are using the same port")
    except Exception as e:
        # Log the error and re-raise the exception
        log_error(str(e))
        raise ValueError

def get_local_ip():
    """Get the local IP address of the current machine."""
    # Get the name of the network interface associated with the default gateway (usually 'eth0' or 'wlan0')
    default_interface = ni.gateways()['default'][ni.AF_INET][1]
    # Get the IP address associated with the network interface
    ip_address = ni.ifaddresses(default_interface)[ni.AF_INET][0]['addr']
    return ip_address

def run_project(project, processes):
    """Run the appropriate command for the project based on its type."""
    try:
        # Define the path to the npm and PHP commands
        npm_path = 'npm'
        php_path = 'php'
        composer_path = 'composer'

        # Check if the project path exists
        if not os.path.exists(project['path']):
            raise FileNotFoundError(f"Could not find project path {project['path']}")

        # Get the IP address of the current machine
        ip_address = get_local_ip()

        # Define a dictionary to act as a switch-case structure
        commands = {
            'node': [npm_path, 'start'],
            'react': [npm_path, 'run', 'dev'],
            'php': [php_path, '-S', f'{ip_address}:' + str(project['port'])]
        }

        # Get the command based on the project type
        command = commands.get(project['type'].lower())

        # If the command is None, it means the project type is not supported
        if command is None:
            raise ValueError(f"Could not start {project['path']} as {project['type']} project")
        
        # Run npm install for Node and React projects
        if project['type'].lower() in ['node', 'react']:
            print(f"Running npm install for {project['path']}")
            subprocess.run([npm_path, 'install'], cwd=project['path'], check=True)

        if project['type'].lower() in ['php']:
            print(f"Running composer install for {project['path']}")
            subprocess.run([composer_path, "install"], cwd=project['path'], check=True)

        process = subprocess.Popen(command, cwd=project['path']) 

        # Add the process to the list of processes
        processes.append(process)
    except Exception as e:
        # Log the error and stop all processes
        log_error(str(e))
        stop_processes(processes)

def stop_processes(processes):
    """Stop all processes."""
    # Terminate each process in the list of processes
    for process in processes:
        process.terminate()

def log_error(message):
    """Log the error message."""
    # Get the current date and time
    timestamp = datetime.datetime.now().strftime("%d-%m-%Y %H-%M-%S")
    
    # Define the log directory and file path
    log_dir = "/app/config/logs"
    log_file_path = f"{log_dir}/{timestamp} log.txt"
    
    # Ensure the log directory exists
    os.makedirs(log_dir, exist_ok=True)
    
    # Open the log file in write mode and log the error
    with open(log_file_path, 'w') as log_file:
        log_file.write(message)
    
    # Print the error message
    print(f"An error occurred: {message}. Check the log file for details.")

def signal_handler(sig, frame):
    """Handle termination signals and stop all processes."""
    print("Received termination signal. Stopping all processes...")
    stop_processes(processes)
    sys.exit(0)


def main():
    """Main function to load the projects and run each one."""
    global processes  # Define processes as global so it's accessible in the signal handler
    processes = []
    
    # Register signal handlers for graceful shutdown
    signal.signal(signal.SIGINT, signal_handler)
    signal.signal(signal.SIGTERM, signal_handler)

    # Load the projects from the JSON file
    projects = load_projects()
    
    # Check if multiple projects are using the same port
    check_ports(projects)
    
    # Run each project
    for project in projects:
        run_project(project, processes)
    
    # Keep the script running
    print("Running projects. Press Ctrl+C to stop or stop the Docker container.")
    signal.pause()  # Wait for a signal (like SIGINT or SIGTERM)

# Run the main function when the script is executed
if __name__ == "__main__":
    main()
