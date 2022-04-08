import bcrypt
from lib.common import toBytes


class Bcrypter:
    @staticmethod
    def hash_password(password):
        return bcrypt.hashpw(toBytes(password), bcrypt.gensalt()).decode('utf-8')

    @staticmethod
    def validate_password(target, source):
        return bcrypt.checkpw(toBytes(target), toBytes(source))
