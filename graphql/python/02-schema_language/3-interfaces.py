import graphene as gp


class Character(gp.Interface):
    id = gp.ID(required=True)
    name = gp.String(required=True)
    friends = gp.List(lambda: Character)


class Human(gp.ObjectType):
    class Meta:
        interfaces = (Character,)

    home_planet = gp.String()


class Droid(gp.ObjectType):
    class Meta:
        interfaces = (Character,)

    primary_function = gp.String()


class Query(gp.ObjectType):
    hero = gp.Field(Character, required=True, episode=gp.Int(required=True))

    def resolve_hero(_, info, episode):
        # Luke is the hero of Episode V
        if episode == 5:
            return Human(name="Luke Skywalker")
        return Droid(name="R2-D2")


schema = gp.Schema(query=Query, types=[Human, Droid])
query = """
    query {
        hero(episode: 2) {
            name
        }
    }
"""


def test_interfaces():
    result = schema.execute(query)
    assert not result.errors
    assert result.data == {"hero": {"name": "R2-D2"}}


if __name__ == "__main__":
    # annotation: inline-fragments
    result = schema.execute(query)
    print(result.data)
