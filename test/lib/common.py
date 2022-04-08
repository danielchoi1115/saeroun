# built-in
import hashlib
import json
from bson import json_util
from bson.objectid import ObjectId

# custom
from lib.literal import LIT


def to_md5(text):
    return hashlib.md5(text.encode('utf-8')).hexdigest()


def to_json(data):
    return json.loads(json_util.dumps(data))


def toBytes(text):
    return bytes(text, LIT.UTF8) if type(text) != bytes else text


def convert_oid_for_mongo(oid):
    oid['_id'] = ObjectId(oid['_id']['$oid'])
    return oid


def get_description(code):
    try:
        return {
            # MongoDB error
            50: 'Invalid Mongo Operation',

            # authentication failures

            'auth-1': 'Email already in use',
            'auth-2': 'Email does not exist',
            'auth-3': 'Wrong Password',

            200: 'API Successful',
            201: 'Register Successful',
            202: 'Login Successful',
        }[code]
    except:
        return 'Unknown Code'

    # {
    #     "errors": {
    #     "message": "'name'(body) must be String, input 'name': 123",
    #     "detail": [
    #         {
    #             "location": "body",
    #             "param": "name",
    #             "value": 123,
    #             "error": "TypeError",
    #             "msg": "must be String"
    #         }
    #         ]
    #     }
    # }
