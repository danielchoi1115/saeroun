
from lib.auth import Bcrypter
from lib.common import convert_oid_for_mongo
from lib.query_handler import YellowMongo


class APIcore:
    def __init__(self):
        self.mongo = YellowMongo()

    def find_user_by_id(self, id):
        return self.mongo.mongo_query(collection='user', query_type='find_one', data=convert_oid_for_mongo(id))

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

    def updateUser(self, id='self', body=None):
        # self update
        if id == 'self':
            # Change my info
            print('Update user info')

        # teacher changing student's account info
        else:
            user = self.find_user_by_id(id)
            # then change information given by kwargs

    def findAllBooks(self):
        # find every books containing its chapters
        return self.mongo.mongo_query(collection='book', query_type='find_all', data={}, projection={'book_name': True, 'book_code': True, 'no_chapter': True})

    def getAllBooks(self, book_id):
        # find every books containing its chapters
        return
