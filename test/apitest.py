import requests

BASE = "http://127.0.0.1:5002"

# data = {
#     "email": "schoaik@connect.hk",
#     "name": "haha",
#     "password": "pass",
#     "password_confirm": "pass"
#     }
# response = requests.post(BASE + "/api/user/new", data)
# print(response.text)

data = {
    "email": "schoaik@connect.hk",
    "password": "pass",
}
response = requests.post(url=BASE + "/api/user", data=data, headers={'Authorization': 'Bearer: '})
print(response.text)
