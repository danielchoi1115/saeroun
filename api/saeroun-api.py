from flask import Flask
from flask_restful import Api, Resource, abort
from pymongo import MongoClient
import json
from bson import json_util
from arg_parser import REGISTER_ARGS_PARSER, LOGIN_ARGS_PARSER

from config import API_RETURN_CODE_DESC, MONGO_DATA
from literal import LIT

client = MongoClient(
    host=MONGO_DATA[LIT.HOST], 
    port=MONGO_DATA[LIT.PORT], 
    username=MONGO_DATA[LIT.USERNAME], 
    password=MONGO_DATA[LIT.PASSWORD]
)
db = client[LIT.SAEROUN]

app = Flask(__name__)
api = Api(app)

def to_json(data):
    return json.loads(json_util.dumps(data))

def mongo_find_one(collection, query):
    result = db[collection].find_one(query)
    return to_json(result)

def mongo_insert_one(collection, data):
    result = db[collection].insert_one(data)
    return result.acknowledged

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
        result = mongo_find_one(collection=LIT.USER, query={LIT.EMAIL: args[LIT.EMAIL]})
        
        # if email is already in use
        if result != None:
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
            acknowledged = mongo_insert_one(collection=LIT.USER, data=args)
            # Invalid Mongo Operation
            if not acknowledged:
                api_result = LIT.FAILED,
                return_code = 103
            # Successfully inserted
            else:
                api_result = LIT.SUCCESS,
                return_code = 201
        
        return {
                LIT.API_RESULT : api_result,
                LIT.API_RETURN_CODE: return_code,
                LIT.DESCRIPTION: get_description(return_code),
                LIT.DATA: to_json(args)
        }

class login(Resource):
    def post(self):
        # Parse post data
        args = LOGIN_ARGS_PARSER.parse_args()
        # Check if email can be used
        result = mongo_find_one(collection=LIT.USER, query={LIT.EMAIL: args[LIT.EMAIL]})
        
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
            
api.add_resource(register, "/register")
api.add_resource(login, "/login")

if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True, port=5001)
    