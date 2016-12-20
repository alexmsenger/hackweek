FROM mysql:5.7
ADD ./config/db_v2.sql /docker-entrypoint-initdb.d/db.sql
