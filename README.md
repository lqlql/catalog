# info
Simple product catalog with cart.
Structure based on rest and some DDD elements.

# docker 
add configs:
	.env.example        -> .env
	app/app.example.php -> app.php
```
docker-compose up -d
```
load sqls and test users:
```
docker exec -it catalog_php-fpm_1  php /var/www/catalog/sql/sql.php

```
test app:
```
GET http://0.0.0.0:8000/api/catalog
```

# tests
```
vendor/bin/phpunit tests/ --configuration tests/phpunit.xml.dist
```
docker:
```
docker exec -it catalog_php-fpm_1 vendor/bin/phpunit /var/www/catalog/tests/ --configuration /var/www/catalog/tests/phpunit.xml.dist
```



# todo
- Add more tests (current test coverage is 20-30%)
- Logging and error handling
- Add auth and users (now only test user for cart functionality)
