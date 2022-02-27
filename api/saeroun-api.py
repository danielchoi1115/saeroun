from ast import Raise
from flask import Flask, jsonify
from flask_restful import Api, Resource


from lib.arg_parser import REGISTER_ARGS_PARSER, LOGIN_ARGS_PARSER
from lib.common import to_json

from lib.literal import LIT, API_RETURN_CODE_DESC

import sys

from lib.query_handler import find_from_email, mongo_query

app = Flask(__name__)
api = Api(app)


def get_description(return_code):
    description = API_RETURN_CODE_DESC.get(return_code)
    if not description:
        description = API_RETURN_CODE_DESC[-1]
    return description

class register(Resource):
    def post(self):
        # Parse post data
        args = REGISTER_ARGS_PARSER.parse_args()
        # Check if email can be used
        query_result = find_from_email(args[LIT.EMAIL])

        # if email is already in use
        if query_result != None:
            api_result = LIT.FAILED
            return_code = 101 
        # if password confirmation failed
        elif args[LIT.PASSWORD] != args[LIT.PASSWORD_CONFIRM]:
            api_result = LIT.FAILED
            return_code = 102 
        else:
            # remove password confirmation data
            del(args[LIT.PASSWORD_CONFIRM])
            # insert user data
            query_result = mongo_query(collection=LIT.USER, type=LIT.INSERT_ONE, data=args)
            # Successfully inserted
            api_result = LIT.SUCCESS,
            return_code = 201
        
        api_return = {
                LIT.API_RESULT : api_result,
                LIT.API_RETURN_CODE: return_code,
                LIT.DESCRIPTION: get_description(return_code),
                LIT.DATA: to_json(args)
        }
        
        return api_return
    
class login(Resource):
    def post(self):
        # Parse post data
        args = LOGIN_ARGS_PARSER.parse_args()
        # Check if email can be used
        query_result = find_from_email(args[LIT.EMAIL])
        
        # Couldn’t find email
        if result is None:
            api_result = LIT.FAILED
            return_code = 104
        # if password confirmation failed
        else:
            user_input = args[LIT.PASSWORD]
            password = result[LIT.PASSWORD]
            # is password doesn't match
            if user_input != password:
                api_result = LIT.FAILED
                return_code = 104
                result = None
            else:
                api_result = LIT.SUCCESS
                return_code = 202 # Login Successful
        return {
                LIT.API_RESULT : api_result,
                LIT.API_RETURN_CODE: return_code,
                LIT.DESCRIPTION: get_description(return_code),
                LIT.DATA: to_json(result)
        }
            
# api.add_resource(Video, "/video/<int:id>")


api.add_resource(register, "/register")
api.add_resource(login, "/login")

if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True, port=5000)
    