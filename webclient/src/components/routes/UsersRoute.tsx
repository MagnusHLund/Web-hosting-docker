import SearchBar from "../input/SearchBar";
import "./UsersRoute.scss";
import Table from "../content/Table"; // Import the new Table component
import Button from "../input/Button";

const UsersRoute: React.FC = () => {
  // Example users data
  const users = [
    {
      id: 1,
      name: "John Doe",
      email: "john.doe@example.com",
      role: "Admin",
      status: "Active",
    },
    {
      id: 2,
      name: "Jane Smith",
      email: "jane.smith@example.com",
      role: "Editor",
      status: "Inactive",
    },
    {
      id: 2,
      name: "Jane Smith",
      email: "jane.smith@example.com",
      role: "Editor",
      status: "Inactive",
    },
  ];

  return (
    <div className="users-route-container">
      <div className="users-route-header">
        <h2 className="users-route-title">Users</h2>
        <div className="users-route-header__actions">
          <SearchBar />
          <Button text="Search"/>
        </div>
      </div>
      <Table users={users} />
    </div>
  );
};

export default UsersRoute;
