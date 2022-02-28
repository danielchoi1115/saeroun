import hashlib
import json
from bson import json_util

from lib.literal import API_RETURN_CODE_DESC

def to_md5(text):
    return hashlib.md5(text.encode('utf-8')).hexdigest()

def to_json(data):
    return json.loads(json_util.dumps(data))

def get_description(return_code):
    description = API_RETURN_CODE_DESC.get(return_code)
    if not description:
        description = API_RETURN_CODE_DESC[-1]
    return description