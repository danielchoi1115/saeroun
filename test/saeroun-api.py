# dependencies
from flask import Flask, jsonify, make_response, request, redirect
from flask_restful import Api, Resource
from flask_cors import CORS
from flask_jwt_extended import (
    JWTManager, jwt_required, create_access_token, get_jwt_identity, unset_jwt_cookies, create_refresh_token, set_access_cookies, set_refresh_cookies
)
# built-in
# import ssl

# Custom
from lib import argparser, ResPacker
from lib.common import to_json
from lib.config import appconfig
from lib.APIcore import APIcore

app = Flask(__name__)
app.config.from_object(appconfig)

jwt = JWTManager(app)
api = Api(app)
CORS(app, resources={r"*": {"origins": '172.30.1.100:8080'}}, supports_credentials=True)


class user(Resource):
    @jwt_required()
    def get(self):
        # TODO
        # Get all student's info
        # return user information (only for the teacher)
        return

    def post(self):
        args = argparser.user()  # Parse post data

        email = args['email']
        username = args['username']
        password = args['password']
        account_type = args['account_type']
        check_only_email = args['check_only_email']
        query_result = core.find_user_by_email(email)

        # Case 0. Check if user email exist
        if check_only_email in ['True', 'true', True]:
            return make_response(ResPacker.user_emailAvailabilityCheck(query_result))

        # Case 1. Sign in a user
        # Email and password should ONLY be given
        if all([email, password]) and not username:
            # Email Found
            if query_result and core.isPasswordCorrect(target=password, source=query_result['password']):
                res_body, status_code = ResPacker.user_signin_successful()
            # Email not Found
            elif not query_result:
                res_body, status_code = ResPacker.user_signin_emailNotFound(email)
            # Password is incorrect
            else:
                res_body, status_code = ResPacker.user_signin_incorrectPassword()

        # Case 2. Sign Up a new user
        elif all([email, password, username]):
            # 'Email already in use'
            if query_result:
                res_body, status_code = ResPacker.user_signup_emailInUse(email)
            # Sign up the user
            else:
                core.insert_user(
                    email=email,
                    username=username,
                    password=password,
                    account_type=account_type
                )
                res_body, status_code = ResPacker.user_signup_successful()

        # Case 3. email, password or username is missing
        else:
            res_body, status_code = ResPacker.user_missingParameter(email, password)

        response = make_response(res_body, status_code)

        if status_code == 200:
            set_access_cookies(response, create_access_token(identity={'_id': query_result['_id']}))
            set_refresh_cookies(response, create_refresh_token(identity={'_id': query_result['_id']}))

        return response

    # TODO
    # update information as given
    def put(self):
        args = argparser.user()
        core.updateUser(args)


class user_(Resource):
    # TODO
    def get(self, id):
        return make_response(to_json(core.find_user_by_id(get_jwt_identity())), 200)

    def put(self, id):
        return


class verification_token(Resource):
    # user authentication으로 변경하는게 통일성 있을듯 함
    @jwt_required(refresh=True)
    def get(self):
        identity = get_jwt_identity()
        access_token = create_access_token(identity=identity)
        return jsonify(access_token=access_token)


class book(Resource):
    @jwt_required()
    def get(self):
        return core.findAllBooks()

class word(Resource):
    @jwt_required()
    def get(self, book_id):
        return core.getAllWords(book_id)
    
api.add_resource(user, "/api/user")
api.add_resource(verification_token, "/api/verification/token")
api.add_resource(book, "/api/book")
api.add_resource(word, "/api/book/<book_id>")
# @app.before_request
# def before_request():
#     if request.url.startswith('http://'):
#         url = request.url.replace('http://', 'https://', 1)
#         code = 301
#         return redirect(url, code=code)


if __name__ == '__main__':
    # ssl_context = ssl.SSLContext(ssl.PROTOCOL_TLS)
    # ssl_context.load_cert_chain(certfile='/usr/share/saeroun/saeroun-web/ssl/domain.com.crt', keyfile='/usr/share/saeroun/saeroun-web/ssl/domain.com.key', password='tmdfuf3752!')
    # app.run(host='0.0.0.0', debug=True, port=5002, ssl_context=ssl_context)
    core = APIcore()
    app.run(host='127.0.0.1', debug=True, port=5002)
    # app.run(host='0.0.0.0', debug=True, port=5002)
