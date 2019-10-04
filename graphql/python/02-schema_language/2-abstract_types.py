import graphene as gp


class UserFields(gp.AbstractType):
    name = gp.String()

    def resolve_name(_, info):
        return "Campo de usuário"


class User(gp.ObjectType, UserFields):
    pass


class Query(gp.ObjectType):
    user = gp.Field(User)

    def resolve_user(_, info):
        return User()


schema = gp.Schema(query=Query)
query = """
    query {
        user {
            name
        }
    }
"""


def test_obstract_types():
    result = schema.execute(query)
    assert not result.errors
    assert result.data == {"user": {"name": "Campo de usuário"}}


if __name__ == "__main__":
    result = schema.execute(query)
    print(result.data)
