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

    def mongo_query(self, collection, query_type, data, projection=None):
        if projection is None:
            projection = {
                'password': False,
                '_id': False
            }
        try:
            if query_type == LIT.INSERT_ONE:
                result = self.db[collection].insert_one(data)
                return result.acknowledged

            elif query_type == LIT.FIND_ONE:
                result = self.db[collection].find_one(data, projection)
                return to_json(result)

        except Exception as ex:
            abort_if_query_failed(ex)
