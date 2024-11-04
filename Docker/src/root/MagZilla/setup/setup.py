import string
import random

def generateRandomString(N):
    ''.join(random.SystemRandom().choice(string.ascii_uppercase + string.digits) for _ in range(N))

def updateEnvFile():
    # Update .env file, for api and web client

def main():
    # Modify api .env file, to include JWT_SECRET_KEY, ENCRYPTION_KEY and KID.
    # Also modify .env file within web client.