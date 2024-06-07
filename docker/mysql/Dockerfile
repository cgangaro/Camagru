FROM mysql:8.0

COPY ./camagru.sql /docker-entrypoint-initdb

CMD [ "mysqld", "--init-file=/docker-entrypoint-initdb/create-local-db.sql" ]
