# Imports
from flask import Flask
from flask_graphql import GraphQLView
import graphene

# app initialization
app = Flask(__name__)
app.debug = True


# Schema Objects
class Query(graphene.ObjectType):
    name = graphene.String()
    version = graphene.String()

    def resolve_name(_, info):
        return "My API"

    def resolve_version(_, info):
        return "v1.0"


schema = graphene.Schema(query=Query)

# Routes
app.add_url_rule(
    "/graphql",
    view_func=GraphQLView.as_view(
        "graphql",
        schema=schema,
        graphiql=True,  # for having the GraphiQL interface
    ),
)


@app.route("/")
def index():
    return "<p> Hello World</p>"


if __name__ == "__main__":
    app.run()
