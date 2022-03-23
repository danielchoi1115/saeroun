from lib.config import MONGO_DATA
from lib.literal import LIT
from lib.common import to_json
from lib.error_handler import abort_if_query_failed

from pymongo import MongoClient


class YellowMongo:
    def __init__(self):
        self.client = MongoClient(
            host=MONGO_DATA[LIT.HOST],
            port=MONGO_DATA[LIT.PORT],
            username=MONGO_DATA[LIT.USERNAME],
            password=MONGO_DATA[LIT.PASSWORD]
        )
        self.db = self.client[LIT.SAEROUN]

    def find_user_by_email(self, email):
        return self.mongo_query(collection=LIT.USER, type=LIT.FIND_ONE, query={LIT.EMAIL: email})

    def mongo_query(self, collection, type, **kwargs):
        try:
            if type == LIT.INSERT_ONE:
                result = self.db[collection].insert_one(kwargs[LIT.DATA])
                return result.acknowledged

            elif type == LIT.FIND_ONE:
                result = self.db[collection].find_one(kwargs[LIT.QUERY])
                return to_json(result)

        except Exception as ex:
            abort_if_query_failed(ex)
