## Deployment:
    1. Clone this repository
    2. composer install
    3. Set env parameters from .env.dist
    4. Create database (bin/console d:d:c)
    5. Execute migrations (bin/console d:m:m)

## Tests:
    1. Set test database connection in phpunit.xml.dist
    2. Run bin/phpunit (or vendor/bin/simple-phpunit)

## Load fixtures
    1. Run bin/console doctrine:fixtures:load -n
    You don't need to run it before tests, it's made automatically
    
## Use api:
    1. Run server bin/console s:start
    2. Get JWT token. Query curl -X POST http://localhost:8000/api/login_check -d _username=admin -d _password=admin
    3. Available endpoints:
        [
            'POST', '/api/team/create' - create new Team
            'PUT', '/api/team/update/{id}' - update existing team
            'GET', '/api/league/show{id}' - show League
            'DELETE', '/api/league/delete/{id}' - delete League
        ]
        
# I added jwt keys in repository and hardcoded admin's creds for testing, of course we must not do that in real life.