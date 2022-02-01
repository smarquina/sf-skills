# Symfony Skills

This simple demo app has the following capabilities

- Create projects via web / console
- Search projects by name (same index list view as previous point)
- Project stats: retrieves current sum of projects and total amount.

### Console commands
- Create project: (from outside php docker container) `$ php bin/console project:add`
  - Command has verbose mode
  - Can be created in a wizard way or inline params
  - For more information read command help
- Project stats: (from outside php docker container) `$ php bin/console project:stats`
  - Command has verbose mode

### 🐞 Testing 
To run tests, please go to project root and run:

    $ docker compose exec php ./vendor/bin/phpunit

## Architecture
This application is written on top of the MVC pattern and following SOLID principles.
The data flow between app logical layers is as following:

    Request
        ↘️                
         Controller ↔️ Service (may use request/reponse classes to communicate)
             ↘️
               Response/Output: in this case this is a view or a text response (case of commands).
               This output may need data transformers in case to be API data response

Although request or response classes are used in the services, 
a real communication bus is not being implemented. 
This can be implemented with [messenger](https://symfony.com/doc/current/messenger.html).
