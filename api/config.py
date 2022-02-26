import hashlib
from Crypto.PublicKey import RSA

def to_md5(text):
    return hashlib.md5(text.encode('utf-8')).hexdigest()
    
MONGO_DATA = {
    'host' : '172.25.0.2',
    'port' : 27017,
    'username' : 'saeroun',
    'password' : 'tmdfuf3752!'
}

API_RETURN_CODE_DESC = {
    -1: 'Unknown Code',
    101: 'Email already in use',
    102: 'Password confirmation failed',
    103: 'Invalid Mongo Operation',
    104: 'Incorrect email or password',
    
    
    201: 'Post Successful',
    202: 'Login Successful',
}