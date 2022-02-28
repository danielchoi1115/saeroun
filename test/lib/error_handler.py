
from flask_restful import abort

def abort_if_query_failed(ex):
    abort(404, message="Query Failed! {}".format(str(ex)))
    
def abort_if_unknown_action(ex):
    abort(404, message="Query Failed! {}".format(str(ex)))
