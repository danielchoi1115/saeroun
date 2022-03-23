import bcrypt
from lib.common import toBytes


class Bcrypter:
    @classmethod
    def hash_password(self, password):
        return bcrypt.hashpw(toBytes(password), bcrypt.gensalt()).decode('utf-8')

    @classmethod
    def validate_password(self, target, source):
        return bcrypt.checkpw(toBytes(target), toBytes(source))
