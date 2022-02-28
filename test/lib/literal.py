# Literal Class

class LIT:
    
    # API Keyword
    NEW = 'new'
    PROPERTY = 'property'
    AUTH = 'auth'
        
    # API
    FAILED = 'failed'
    SUCCESS = 'success'
    API_RETURN_CODE = 'api_return_code'
    API_RESULT = 'api_result'
    DESCRIPTION = 'description'
    DATA = 'data'
    ERROR = 'error'
    
    # POST DATA LITERAL
    EMAIL = 'email'
    NAME = 'name'
    PASSWORD_CONFIRM = 'password_confirm'
    
    # MONGO
    HOST = 'host'
    PORT = 'port'
    USERNAME = 'username'
    PASSWORD = 'password'
    SAEROUN = 'saeroun' # DB name
    USER = 'user' # collection name
    CLASS = 'class' # collection name
    QUERY = 'query'
    
    # MONGO KEYWORD
    INSERT_ONE = 'insert_one'
    FIND_ONE = 'find_one'
    
    
    
API_RETURN_CODE_DESC = {
    -1: 'Unknown Code',
    
    # MongoDB error
    50: 'Invalid Mongo Operation',
    
    # User error
    101: 'Email already in use',
    102: 'Password confirmation failed',
    104: 'Incorrect email or password',
    
    201: 'Post Successful',
    202: 'Login Successful',
}