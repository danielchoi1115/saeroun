import json
from bson import json_util

def to_json(data):
    return json.loads(json_util.dumps(data))

print(to_json({1:'a'}))