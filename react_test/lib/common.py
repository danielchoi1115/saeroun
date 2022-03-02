import hashlib
import json
from bson import json_util

def to_md5(text):
    return hashlib.md5(text.encode('utf-8')).hexdigest()

def to_json(data):
    return json.loads(json_util.dumps(data))

def get_description(return_code):
    try:    
        return {
            # MongoDB error
            50: 'Invalid Mongo Operation',
            
            # User error
            101: 'Email already in use',
            102: 'Password confirmation failed',
            104: 'Incorrect email or password',
            
            201: 'Post Successful',
            202: 'Login Successful',
        }[return_code]
    except:
        return 'Unknown Code'