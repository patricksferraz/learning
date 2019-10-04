import graphene


class CreatePerson(graphene.Mutation):
    # arguments that mutation needs for resolving
    class Arguments:
        name = graphene.String()

    # output fields
    ok = graphene.Boolean()
    person = graphene.Field(lambda: Person)

    def mutate(self, info, name):
        person = Person(name=name)
        ok = True
        return CreatePerson(person=person, ok=ok)


class MyMutations(graphene.ObjectType):
    create_person = CreatePerson.Field()


class Person(graphene.ObjectType):
    name = graphene.String()
    age = graphene.Int()


# # We must define a query for our schema
# class Query(graphene.ObjectType):
#     person = graphene.Field(Person)


schema = graphene.Schema(mutation=MyMutations)
query = """
    mutation {
        createPerson(name:"Peter") {
            person {
                name
            }
            ok
        }
    }
"""


def test_mutations():
    result = schema.execute(query)
    print(result.data)
    assert not result.errors
    assert result.data == {
        "createPerson": {"person": {"name": "Peter"}, "ok": True}
    }


if __name__ == "__main__":
    result = schema.execute(query)
    print(result.data)
