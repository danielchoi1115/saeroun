
from lib.auth import Bcrypter
from lib.common import convert_oid_for_mongo
from lib.query_handler import YellowMongo


class APIcore:
    def __init__(self):
        self.mongo = YellowMongo()

    def find_user_by_id(self, identity):
        return self.mongo.mongo_query(collection='user', query_type='find_one', data=convert_oid_for_mongo(identity))

    def find_user_by_email(self, email):
        return self.mongo.mongo_query(collection='user', query_type='find_one', data={'email': email}, projection={'email': True, 'password': True, '_id': True})

    def insert_user(self, email, password, username, account_type):
        if account_type in [None, '']:
            account_type = 'pending'
        args = {
            'email': email,
            'username': username,
            'password': Bcrypter.hash_password(password),
            'account_type': account_type
        }
        return self.mongo.mongo_query(collection='user', query_type='insert_one', data=args)

    def isPasswordCorrect(self, target, source):
        return Bcrypter.validate_password(target, source)
