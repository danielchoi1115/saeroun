from flask_restful import reqparse
from lib.literal import LIT


class argparser:
    register = reqparse.RequestParser()
    register.add_argument(LIT.EMAIL, type=str, help="", required=True)
    register.add_argument(LIT.STUDENT_NAME, type=str, help="", required=True)
    register.add_argument(LIT.PASSWORD, type=str, help="", required=True)
    register.add_argument(LIT.PASSWORD_CONFIRM, type=str, help="", required=True)

    login = reqparse.RequestParser()
    login.add_argument(LIT.EMAIL, type=str, help="", required=True)
    login.add_argument(LIT.PASSWORD, type=str, help="", required=True)
