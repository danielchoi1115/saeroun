from lib.config import MONGO_DATA
from lib.literal import LIT
from lib.common import to_json

from pymongo import MongoClient

client = MongoClient(
    host=MONGO_DATA[LIT.HOST], 
    port=MONGO_DATA[LIT.PORT], 
    username=MONGO_DATA[LIT.USERNAME], 
    password=MONGO_DATA[LIT.PASSWORD]
)
db = client[LIT.SAEROUN]

def find_from_email(email):
    return mongo_query(collection=LIT.USER, type=LIT.FIND_ONE, query={LIT.EMAIL: email})

def mongo_query(collection, type, **kwargs):
    try:
        if type == LIT.INSERT_ONE:
            result = db[collection].insert_one(kwargs[LIT.DATA])
            return result.acknowledged

        elif type == LIT.FIND_ONE:
            result = db[collection].find_one(kwargs[LIT.QUERY])
            return to_json(result)
        
    except Exception as ex:
        # abort_if_query_failed(ex)
        print(ex)
