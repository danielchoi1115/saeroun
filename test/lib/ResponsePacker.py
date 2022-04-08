
class ResPacker:
    @staticmethod
    def user_emailAvailabilityCheck(query_result):
        if query_result:
            return format_response_body('errors', 'Email is already in use, please use other email.', {
                "location": "body",
                "param": "email",
                "value": query_result['email']
            }), 409
        else:
            return format_response_body('success', 'The email is valid'), 200

    @staticmethod
    def user_signin_successful():
        return format_response_body('success', 'Successfully signed in'), 200

    @staticmethod
    def user_signin_emailNotFound(email):
        return format_response_body('errors', 'Email does not exist', {
            "location": "body",
            "param": "email",
            "value": email
        }), 404

    @staticmethod
    def user_signin_incorrectPassword():
        return format_response_body('errors', 'Incorrect password, please check your password', {
            "location": "body",
            "param": "password"
        }), 401

    @staticmethod
    def user_signup_successful():
        return format_response_body('success', 'Successfully signed up'), 201

    @staticmethod
    def user_signup_emailInUse(email):
        return format_response_body('errors', 'Email is already in use, please use other email.', {
            "location": "body",
            "param": "email",
            "value": email
        }), 409

    @staticmethod
    def user_missingParameter(email, password):
        return format_response_body('errors', 'Email and password must be given to sign in or sign up.', {
            "location": "body",
            "missing_parameter": f"{', '.join([prop for prop in [email, password] if not prop])}"
        }), 422


def format_response_body(result, message, detail=None):
    response_body = {
        result: {
            'message': message,
        }
    }
    if detail is not None:
        response_body[result]['detail'] = detail

    return response_body
