php -S 127.0.0.1:8080
mariadb -h localhost -P 3306 --protocol=tcp -u root --password=mariadb -D mariadb < mock/db-creation.sql