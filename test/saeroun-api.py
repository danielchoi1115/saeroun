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
from lib.common import to_json, convert_oid_for_mongo
from lib.config import appconfig
from lib.literal import LIT
from lib.query_handler import YellowMongo
from lib.auth import Bcrypter

app = Flask(__name__)
app.config.from_object(appconfig)

jwt = JWTManager(app)
api = Api(app)
CORS(app, resources={r"*": {"origins": '172.30.1.100:8080'}}, supports_credentials=True)


class user(Resource):
    @jwt_required()
    def get(self):
        # with token:
        print(get_jwt_identity())
        oid = convert_oid_for_mongo(get_jwt_identity())
        print(oid)
        query_result = mongo.mongo_query(collection=LIT.USER, query_type=LIT.FIND_ONE, data=oid)
        response = make_response(to_json(query_result), 200)
        return response
        #   return user information (only for the teacher)

    def post(self):

        args = argparser().user()  # Parse post data

        email = args['email']
        student_name = args['student_name']
        password = args['password']

        # check if arg.email is there:

        userdata = {}
        # if user does not exist
        data = {'email': email}
        projection = {
            'password': True,
            '_id': True
        }
        query_result = mongo.mongo_query(collection=LIT.USER, query_type=LIT.FIND_ONE, data=data, projection=projection)
        if query_result:
            # 이 기능은 프론트에서 대신할 예정이지만
            if student_name:
                userdata['info'] = 'User already exist'
            elif Bcrypter.validate_password(target=password, source=query_result['password']):
                userdata['info'] = 'Return Tokens'
                info = {'_id': query_result['_id']}
                userdata['access_token'] = create_access_token(identity=info)
                userdata['refresh_token'] = create_refresh_token(identity=info)
            else:
                userdata['info'] = 'Email or password wrong'
        elif student_name:
            args = {
                'email': email,
                'student_name': student_name,
                'password': Bcrypter.hash_password(password)
            }
            query_result = mongo.mongo_query(collection=LIT.USER, query_type=LIT.INSERT_ONE, data=args)
            userdata['info'] = 'Create a new user'
        elif password:
            userdata['info'] = 'Email does not exist'

        response = make_response(userdata, 200)
        if 'access_token' in userdata:
            set_access_cookies(response, userdata['access_token'])
        if 'refresh_token' in userdata:
            set_refresh_cookies(response, userdata['refresh_token'])

        return response


class verification_token(Resource):
    @jwt_required(refresh=True)
    def get(self):
        identity = get_jwt_identity()
        access_token = create_access_token(identity=identity)
        return jsonify(access_token=access_token)


api.add_resource(user, "/api/user")
api.add_resource(verification_token, "/api/verification/token")
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

    mongo = YellowMongo()

    app.run(host='127.0.0.1', debug=True, port=5002)
    # app.run(host='0.0.0.0', debug=True, port=5002)
