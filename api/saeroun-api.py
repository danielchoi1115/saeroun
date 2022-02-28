from flask import Flask, jsonify
from flask_restful import Api, Resource

from lib.arg_parser import REGISTER_ARGS_PARSER, LOGIN_ARGS_PARSER
from lib.common import to_json
from lib.literal import LIT, get_description
from lib.query_handler import find_from_email, mongo_query

app = Flask(__name__)
api = Api(app)

class user(Resource):
    def post(self, keyword):
        if keyword == LIT.AUTH:
            args = LOGIN_ARGS_PARSER.parse_args() # Parse post data
            return user_post_auth(args)
        
        elif keyword == LIT.NEW:
            args = REGISTER_ARGS_PARSER.parse_args() # Parse post data
            return user_post_new(args)
        
def user_post_auth(args):
    # Check if email can be used
    query_result = find_from_email(args[LIT.EMAIL])
    # Could’t find email
    if query_result is None:
        api_result = LIT.FAILED
        return_code = 104
    # if password confirmation failed
    else:
        user_input = args[LIT.PASSWORD]
        password = query_result[LIT.PASSWORD]
        # is password doesn't match
        if user_input != password:
            api_result = LIT.FAILED
            return_code = 104
            query_result = None
        else:
            api_result = LIT.SUCCESS
            return_code = 202 # Login Successful
    return {
            LIT.API_RESULT : api_result,
            LIT.API_RETURN_CODE: return_code,
            LIT.DESCRIPTION: get_description(return_code),
            # LIT.DATA: to_json(query_result)
    }

def user_post_new(args):
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
        # insert user data
        query_result = mongo_query(collection=LIT.USER, type=LIT.INSERT_ONE, data=args)
        # Successfully Registered
        api_result = LIT.SUCCESS,
        return_code = 201
        # remove password confirmation data
        del(args[LIT.PASSWORD_CONFIRM])
        
    api_return = {
            LIT.API_RESULT : api_result,
            LIT.API_RETURN_CODE: return_code,
            LIT.DESCRIPTION: get_description(return_code),
            LIT.DATA: to_json(args)
    }
    
    return api_return


api.add_resource(user, "/api/user/<string:keyword>")

if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True, port=5001)
    