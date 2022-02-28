from flask_restful import reqparse
from lib.literal import LIT
REGISTER_ARGS_PARSER = reqparse.RequestParser()
REGISTER_ARGS_PARSER.add_argument(LIT.EMAIL, type=str, help="", required=True)
REGISTER_ARGS_PARSER.add_argument(LIT.NAME, type=str, help="", required=True)
REGISTER_ARGS_PARSER.add_argument(LIT.PASSWORD, type=str, help="", required=True)
REGISTER_ARGS_PARSER.add_argument(LIT.PASSWORD_CONFIRM, type=str, help="", required=True)

LOGIN_ARGS_PARSER = reqparse.RequestParser()
LOGIN_ARGS_PARSER.add_argument(LIT.EMAIL, type=str, help="", required=True)
LOGIN_ARGS_PARSER.add_argument(LIT.PASSWORD, type=str, help="", required=True)

