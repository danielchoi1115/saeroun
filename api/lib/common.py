import hashlib
import json
from bson import json_util

def to_md5(text):
    return hashlib.md5(text.encode('utf-8')).hexdigest()

def to_json(data):
    return json.loads(json_util.dumps(data))