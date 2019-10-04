# from enum import Enum
from graphene import Enum


class Episode(Enum):
    NEWHOPE = 4
    EMPIRE = 5
    JEDI = 6

    @property
    def description(self):
        if self == Episode.NEWHOPE:
            return "NEWHOPE"
        elif self == Episode.EMPIRE:
            return "EMPIRE"
        elif self == Episode.JEDI:
            return "JEDI"


def test_enum():
    result = Episode.NEWHOPE
    assert result.description == "NEWHOPE"

r = Episode.NEWHOPE
print(r.description)