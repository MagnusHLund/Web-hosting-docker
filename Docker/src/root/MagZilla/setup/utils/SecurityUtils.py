import string
import random

class SecurityManager: 
    @staticmethod
    def generate_random_string(self, n):
        return ''.join(random.SystemRandom().choice(string.ascii_uppercase + string.digits) for _ in range(n))