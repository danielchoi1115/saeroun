from flask_restful import reqparse
from lib.literal import LIT
import json


def user():
    user = reqparse.RequestParser()
    user.add_argument(LIT.EMAIL, type=str, help="", required=True)
    user.add_argument(LIT.USERNAME, type=str, help="")
    user.add_argument(LIT.PASSWORD, type=str, help="")
    user.add_argument(LIT.PASSWORD_CONFIRM, type=str, help="")
    user.add_argument(LIT.AUTHORIZATION, location='headers')
    user.add_argument('account_type')
    user.add_argument('check_only_email')
    return user.parse_args()


# class argparser():
#     @classmethod
#     def user(self):
#         user = reqparse.RequestParser()
#         user.add_argument(LIT.EMAIL, type=str, help="", required=True)
#         user.add_argument(LIT.STUDENT_NAME, type=str, help="")
#         user.add_argument(LIT.PASSWORD, type=str, help="", required=True)
#         user.add_argument(LIT.PASSWORD_CONFIRM, type=str, help="")
#         user.add_argument(LIT.AUTHORIZATION, location='headers')
#         print(user.parse_args())
#         return args(**user.parse_args())


# class args():
#     # initializes a class similar to a tuple class.
#     # every arguments passed from argparser() will be initialized as class attributes
#     def __init__(self, **kwargs):
#         self.__dict__.update(kwargs)

#     def __repr__(self):
#         return json.dumps(self.__dict__)

#     # custom __getattr__ function
#     # return None if attribute does not exist instead of AttributeError
#     def __getattr__(self, __name):
#         return object.__getattribute__(self, __name) if __name in self.__dict__ else None
