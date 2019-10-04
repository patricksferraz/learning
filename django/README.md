# Learning Django

This project was used as a learning tool for Django

## Comments

1. [__class F__][1]

 Important for arithmetic operations in the database

 * Usage
    ```python
    from django.db.models import F

    reporter = Reporters.objects.get(name='Tintin')
    reporter.stories_filed = F('stories_filed') + 1
    reporter.save()
    ```

2. [__Selenium__][2]

 Framework to test your application in the browser

3. [__coverage.py__][3]

 Code coverage describes how much source code has been tested.

 * Usage

    ```bash
    # Install
    $ pip install coverage
    # running on dir /mysite
    $ coverage run --source='.' manage.py test myapp
    # see a report
    $ coverage report
    ```

[1]: https://docs.djangoproject.com/en/2.1/ref/models/expressions/#f-expressions
[2]: https://www.seleniumhq.org/
[3]: https://docs.djangoproject.com/pt-br/2.1/topics/testing/advanced/#integration-with-coverage-py
