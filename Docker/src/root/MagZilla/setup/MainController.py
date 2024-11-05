from utils import SecurityUtils

class MainController:

    def main(self):
        values_to_insert = self.generate_values()

    def generate_values(self):
        security_utils = SecurityUtils()
        jwt_secret_key = security_utils.generate_random_string(32)
        encryption_key = security_utils.generate_random_string(32)
        kid =            security_utils.generate_random_string(32)

        return {
            "jwt_secret_key": jwt_secret_key, 
            "encryption_key": encryption_key, 
            "kid": kid
        }

if __name__ == "__main__":
    main()