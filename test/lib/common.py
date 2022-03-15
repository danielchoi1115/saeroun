# built-in
import hashlib
import json
from bson import json_util

# custom 
from lib.literal import LIT


def to_md5(text):
    return hashlib.md5(text.encode('utf-8')).hexdigest()


def to_json(data):
    return json.loads(json_util.dumps(data))


def to_bytes(text):
    return bytes(text, LIT.UTF8) if type(text) != bytes else text


def get_description(code):
    try:
        return {
            # MongoDB error
            50: 'Invalid Mongo Operation',

            # User error
            101: 'Email already in use',
            102: 'Password confirmation failed',
            104: 'Incorrect email or password',

            201: 'Register Successful',
            202: 'Login Successful',
        }[code]
    except:
        return 'Unknown Code'
