from flask import Flask, redirect, url_for, render_template, request, session
import secrets

app = Flask(__name__)
app.secret_key = secrets.token_urlsafe(16)

@app.route("/")
def default():
    return redirect(url_for("login"))

@app.route("/login", methods=["POST", "GET"])
def login():
    if "username" in session:
        return redirect(url_for("login"))
    if request.method == "POST":
        email = request.form["email"]
        session['username'] = email
        session['password'] = request.form["password"]
        return redirect(url_for("home"))
    else:
        return render_template("registration/login.html")

@app.route("/home")
def home():
    if "username" in session:
        return "<h1>{}, {}</h1>".format(session["username"], session["password"])
    else:
        return redirect(url_for("login"))

@app.route("/logout")
def logout():
    session.clear()
    return redirect(url_for("login"))

if __name__ == "__main__":
    app.run(host='0.0.0.0', debug=True, port=7000)
    