# dependencies
import jwt
from cryptography.fernet import Fernet, InvalidToken

# built-in
from datetime import datetime, timedelta

# custom
from lib.config import confidential, Settings
from lib.literal import LIT
from lib.common import to_bytes


class YellowToken:
    def __init__(self):
        self.secret_key = confidential.API_SECRET_KEY
        self.fernet_key = confidential.FERNET_KEY

    def generate_fernet_key(self):
        return Fernet.generate_key().decode(LIT.UTF8)

    def create_token(self, data, expire_time=Settings.DEFAULT_TOKEN_EXPIRE_TIME):
        """Creates token

        Args:
            data (dict): User data
            expire_time (int, optional): Token expiration time in minutes. Defaults to 30 minutes

        Returns:
            str: return token in string
        """
        data[LIT.EXP] = datetime.utcnow() + timedelta(minutes=expire_time)
        return self.fernet_encrypt(
            jwt.encode(
                payload=data,
                key=self.secret_key,
                algorithm="HS256"
            )
        )

    def verify_token(self, token):
        try:
            data = jwt.decode(jwt=self.fernet_decrypt(token), key=self.secret_key, algorithms=["HS256"])
            return 'token is valid'

        except jwt.ExpiredSignatureError:
            return 'ExpiredSignatureError'

        except jwt.InvalidTokenError:
            return 'InvalidTokenError'

    def fernet_encrypt(self, text):
        return Fernet(self.fernet_key).encrypt(to_bytes(text)).decode(LIT.UTF8)

    def fernet_decrypt(self, text):
        try:
            return Fernet(self.fernet_key).decrypt(to_bytes(text)).decode(LIT.UTF8)
        except InvalidToken:
            return ''


a = YellowToken()
b = a.fernet_decrypt('gAAAAABiMJ-etfKX7QQd3-AStho2kQzE56PGjDQORRr6737OdogGGAp60wbUiVc6arSVOPGVw5qlR0qKzM4o7dX662p--2frn30bTCbfxscOcsBxE7G-VTHOmbDkv4SSbACmTzD_5Zn7RG3ojUdzYwL7YXoiZ7CVRqQRfesjqsmqMz08yOMoZeko4cy0pyG844jlN_xt-hYYmmh9ro96i6KHZBHwBYtpZ5BQbA9LfrVqeEOZbWL6VZe3SRimejRmRk41cqGRLwqquaTma3Nmu8Kxcqpte5IBwQ==')
print(b)
