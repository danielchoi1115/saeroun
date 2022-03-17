# # dependencies
# from flask_jwt_extended import create_access_token, create_refresh_token
# import jwt
# from cryptography.fernet import Fernet, InvalidToken

# # built-in
# from datetime import datetime, timedelta

# # custom
# from lib.config import confidential
# from lib.error_handler import MissingParameterError
# from lib.literal import LIT
# from lib.common import to_bytes


# def create_token(identity=None, token_type=False, expires_delta=None):
#     if not identity or not token_type:
#         raise MissingParameterError("You must provide identity and token type")

#     if token_type == 'access':
#         token = create_access_token(identity=identity, expires_delta=expires_delta)
#     if token_type == 'refresh':
#         token = create_refresh_token(identity=identity, expires_delta=expires_delta)
#     return token

# # a = YellowToken()
# # b = a.fernet_decrypt('gAAAAABiMJ-etfKX7QQd3-AStho2kQzE56PGjDQORRr6737OdogGGAp60wbUiVc6arSVOPGVw5qlR0qKzM4o7dX662p--2frn30bTCbfxscOcsBxE7G-VTHOmbDkv4SSbACmTzD_5Zn7RG3ojUdzYwL7YXoiZ7CVRqQRfesjqsmqMz08yOMoZeko4cy0pyG844jlN_xt-hYYmmh9ro96i6KHZBHwBYtpZ5BQbA9LfrVqeEOZbWL6VZe3SRimejRmRk41cqGRLwqquaTma3Nmu8Kxcqpte5IBwQ==')
# # print(b)
