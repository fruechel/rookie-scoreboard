psql "host=$PG_DB_HOST user=$PG_DB_ROLE password=$PG_DB_PASSWORD dbname=$PG_DB_SCHEMA" < install/schema.sql
php -S 0.0.0.0:8080
