from Crypto.PublicKey import RSA
from Crypto import Random
from Crypto.Cipher import PKCS1_OAEP

def generateKeyFiles():
    private_key = RSA.generate(1024)
    public_key = private_key.publickey()
    with open ("private.pem", "w") as prv_file:
        print("{}".format(private_key.exportKey().decode("UTF8")), file=prv_file)
    with open ("public.pem", "w") as pub_file:
        print("{}".format(public_key.exportKey().decode("UTF8")), file=pub_file)
        
with open("public.pem", 'r') as pub_file:
    pubkey = RSA.importKey(pub_file.read())
with open("private.pem", 'r') as prv_file:
    prvkey = RSA.importKey(prv_file.read())
