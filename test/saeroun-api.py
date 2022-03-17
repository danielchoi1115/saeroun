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
from lib.arg_parser import argparser
from lib.common import get_description
from lib.config import appconfig
from lib.literal import LIT
from lib.query_handler import find_user_by_email, mongo_query


app = Flask(__name__)
app.config.from_object(appconfig)

jwt = JWTManager(app)
api = Api(app)
CORS(app, resources={r"*": {"origins": '172.30.1.100:8080'}}, supports_credentials=True)


class user(Resource):
    # def get(self):
    #     # with token:
    #     #   return user information (only for the teacher)

    #     # without token:
    #     #   return invalid operation

    #     # args = argparser.post_user.parse_args()  # Parse post data
    #     # result, status_code = post_user(args)
    #     # if LIT.ACCESS_TOKEN in result:
    #     #     return make_response(result, status_code)
    #     access_token = create_access_token(identity='haha'),
    #     refresh_token = create_refresh_token(identity='hoho')
    #     resp = {'login': True}
    #     set_access_cookies(resp, access_token)
    #     set_refresh_cookies(resp, refresh_token)
    #     return {
    #         "access": access_token,
    #         "refresh": refresh_token
    #     }

    def post(self):

        args = argparser().user()  # Parse post data

        email = args['email']
        student_name = args['student_name']
        password = args['password']

        # check if arg.email is there:
        query_result = find_user_by_email(email)
        data = {}

        # if user does not exist
        if not query_result:
            # and if student name is given, create user
            if student_name:
                data['info'] = 'Create a new user'
            # if student name is not given (if only email and password is given)
            # redirect to sign up page
            elif password:
                data['info'] = 'Email or password wrong'
        # if user already exist
        else:
            if student_name:
                data['info'] = 'User already exist'
            else:
                # if user authentication is valid
                if query_result['password'] == password:
                    data['info'] = 'Return Tokens'
                    data['access_token'] = create_access_token(identity={'email': email})
                    data['refresh_token'] = create_refresh_token(identity=email)
                else:
                    data['info'] = 'Email or password wrong'

        #   return token (sign in)
        # if no user exist:
        #   redirects to the sign up page.
        # with extra information:
        #   creates a new user (sign up)

        response = make_response(data, 200)
        if 'access_token' in data:
            set_access_cookies(response, data['access_token'])
        if 'refresh_token' in data:
            set_refresh_cookies(response, data['refresh_token'])

        return response

        # return post_user(args)


def post_user(args):

    # Get the info by email
    query_result = find_user_by_email(args[LIT.EMAIL])
    matched = args[LIT.PASSWORD] == query_result[LIT.PASSWORD]

    # if user exist:
    #     return token (sign in)

    # case 1 - user exist
    if query_result and matched:
        return {
            LIT.API_RESULT: LIT.SUCCESS,
            LIT.DESCRIPTION: get_description(202),  # Login Successful
            # LIT.ACCESS_TOKEN: YellowToken().create_token(data=query_result['_id'])
        }, 200  # HTTP OK
    elif not matched:
        return {
            LIT.API_RESULT: LIT.FAILED,
            LIT.DESCRIPTION: get_description(104),  # Incorrect email or password
        }, 401  # Unauthorized
    # elif user not exist:
    #     if 4 args are given
    #         creates a new user (sign up)

    #     else (only email and password sent:)
    #         redirects to the sign up page.

    # Could’t find email or password does not match
    # if (not query_result) or (args[LIT.PASSWORD] != query_result[LIT.PASSWORD]):


def get_user(args):
    # Check if email can be used
    query_result = find_user_by_email(args[LIT.EMAIL])

    # if email is available
    if not query_result:
        # insert user data
        del(args[LIT.PASSWORD_CONFIRM])  # no need to input confirm password data
        query_result = mongo_query(collection=LIT.USER, type=LIT.INSERT_ONE, data=args)
        # Successfully Registered
        return {
            LIT.API_RESULT: LIT.SUCCESS,
            LIT.DESCRIPTION: get_description(201),  # Sign in Successful
        }, 201  # POST Successful

    else:
        return {
            LIT.API_RESULT: LIT.FAILED,
            LIT.DESCRIPTION: get_description(101)  # email already in use
        }, 401  # Unauthrorized


api.add_resource(user, "/api/user")

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
    app.run(host='127.0.0.1', debug=True, port=5002)
    # app.run(host='0.0.0.0', debug=True, port=5002)
