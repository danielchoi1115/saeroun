# dependencies
from flask import Flask, make_response, request, redirect
from flask_restful import Api, Resource
from flask_cors import CORS

# built-in
# import ssl

# Custom
from lib.arg_parser import argparser
from lib.common import get_description
from lib.config import confidential
from lib.literal import LIT
from lib.query_handler import find_user_by_email, mongo_query
from lib.auth import YellowToken


app = Flask(__name__)
app.config['SECRET_KEY'] = confidential.API_SECRET_KEY
app.config['CORS_HEADERS'] = 'Content-Type'

api = Api(app)
# , resources={r"*": {"origins": "*"}}

CORS(app, resources={r"*": {"origins": '175.194.158.210'}})


class user(Resource):
    def post(self, keyword):
        if keyword == LIT.AUTH:
            args = argparser.login.parse_args()  # Parse post data
            result, status_code = user_post_auth(args)
            # res =
            # if status_code == 200:
            #     res.set_cookie(
            #         key=LIT.ACCESS_TOKEN,
            #         value=result[LIT.ACCESS_TOKEN],
            #         httponly=True,
            #         domain='175.194.158.210',
            #     )
            if LIT.ACCESS_TOKEN in result:
                return make_response(result, status_code)
        elif keyword == LIT.NEW:
            args = argparser.register.parse_args()  # Parse post data
            return user_post_new(args)


def user_post_auth(args):
    # Get the info by email
    query_result = find_user_by_email(args[LIT.EMAIL])

    # Could’t find email or password does not match
    if (not query_result) or (args[LIT.PASSWORD] != query_result[LIT.PASSWORD]):
        return {
            LIT.API_RESULT: LIT.FAILED,
            LIT.DESCRIPTION: get_description(104),  # Incorrect email or password
        }, 401  # Unauthorized

    yellowtoken = YellowToken()
    return {
        LIT.API_RESULT: LIT.SUCCESS,
        LIT.DESCRIPTION: get_description(202),  # Login Successful
        LIT.ACCESS_TOKEN: yellowtoken.create_token(data=query_result['_id'])
    }, 200  # HTTP OK


def user_post_new(args):
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


api.add_resource(user, "/api/user/<string:keyword>")

# @app.before_request
# def before_request():
#     if request.url.startswith('http://'):
#         url = request.url.replace('http://', 'https://', 1)
#         code = 301
#         return redirect(url, code=code)


@app.route('/api/haha')
def haha():
    return 'hello'


if __name__ == '__main__':
    # ssl_context = ssl.SSLContext(ssl.PROTOCOL_TLS)
    # ssl_context.load_cert_chain(certfile='/usr/share/saeroun/saeroun-web/ssl/domain.com.crt', keyfile='/usr/share/saeroun/saeroun-web/ssl/domain.com.key', password='tmdfuf3752!')
    # app.run(host='0.0.0.0', debug=True, port=5002, ssl_context=ssl_context)
    app.run(host='127.0.0.1', debug=True, port=5002)
