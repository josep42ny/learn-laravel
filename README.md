php -S 127.0.0.1:8080 -t public
mariadb -h localhost -P 3306 --protocol=tcp -u root --password=mariadb < mock/init.sql