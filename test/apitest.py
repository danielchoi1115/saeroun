import requests

BASE = "http://172.30.1.100:5001"

data = {
    "email": "schoaik@connect.hk",
    "name": "haha", 
    "password": "pass",
    "password_confirm": "pass"
    }
response = requests.post(BASE + "/api/user/new", data)
print(response.text)

# data = {
#     "email": "schoaik@connect.hk",
#     "password": "pass",
#     }
# response = requests.post(BASE + "/api/user/auth", data)
# print(response.text)