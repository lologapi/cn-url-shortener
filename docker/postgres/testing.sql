CREATE USER testing WITH SUPERUSER PASSWORD 'testing';
CREATE DATABASE url_shortener_database_test;
GRANT ALL PRIVILEGES ON DATABASE url_shortener_database_test TO testing;