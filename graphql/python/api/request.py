import requests

URL = "http://127.0.0.1:5000/graphql"

headers = {"content-type": "application/json"}

payload = """
    query {
        name
        version
    }
"""


def test_api():
    result = requests.post(URL, headers=headers, json={"query": payload})
    assert result.status_code == 200
    assert result.json() == {"data": {"name": "My API", "version": "v1.0"}}


if __name__ == "__main__":
    result = requests.post(URL, headers=headers, json={"query": payload})
    print("status: {}\n{}".format(result.status_code, result.json()))
