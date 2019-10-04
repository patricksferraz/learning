# annotation (argument)

import graphene as gp

# meta class (name)
class Query(gp.ObjectType):
    # annotation (resolver)
    hello = gp.String()

    def resolve_hello(_, info):
        return "Hello World"


# arguments (query, mutations, types, auto_camelcase)
schema = gp.Schema(query=Query)
query = """
    query {
        hello
    }
"""


def test_object_types():
    result = schema.execute(query)
    assert not result.errors
    assert result.data == {"hello": "Hello World"}


if __name__ == "__main__":
    result = schema.execute(query)
    print(result.data)
