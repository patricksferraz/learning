import graphene as gp


class Human(gp.ObjectType):
    name = gp.String()
    born_in = gp.String()


class Droid(gp.ObjectType):
    name = gp.String()
    primary_function = gp.String()


class Starship(gp.ObjectType):
    name = gp.String()
    length = gp.Int()


class SearchResult(gp.Union):
    class Meta:
        types = (Human, Droid, Starship)


class Query(gp.ObjectType):
    result = gp.Field(
        SearchResult, required=True, episode=gp.Int(required=True)
    )

    def resolve_result(_, info, episode):
        if episode == 5:
            return Human(name="Luke Skywalker")
        return Droid(name="R2-D2")


schema = gp.Schema(query=Query)
query = """
    query {
        result(episode: 2) {
            ... on Droid {
                name
            }
        }
    }
"""


def test_unions():
    result = schema.execute(query)
    assert not result.errors
    assert result.data == {"result": {"name": "R2-D2"}}


if __name__ == "__main__":
    result = schema.execute(query)
    print(result.data)
