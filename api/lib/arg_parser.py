from flask_restful import reqparse

REGISTER_ARGS_PARSER = reqparse.RequestParser()
REGISTER_ARGS_PARSER.add_argument("email", type=str, help="Name of the video", required=True)
REGISTER_ARGS_PARSER.add_argument("name", type=str, help="Name of the video", required=True)
REGISTER_ARGS_PARSER.add_argument("password", type=str, help="Number of likes", required=True)
REGISTER_ARGS_PARSER.add_argument("password_confirm", type=str, help="Views Count", required=True)

LOGIN_ARGS_PARSER = reqparse.RequestParser()
LOGIN_ARGS_PARSER.add_argument("email", type=str, help="Name of the video", required=True)
LOGIN_ARGS_PARSER.add_argument("password", type=str, help="Number of likes", required=True)

