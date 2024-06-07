all: start

start:
	docker-compose up -d

restart: 
	docker-compose restart

stop:
	docker-compose down

list:
	docker-compose ps

logs:
	docker-compose logs $(LOGS_ARGS)

clean:
	docker-compose down -v --rmi all --remove-orphans

fclean: clean
	docker system prune --all --force --volumes
	rm -rf ./database

re : fclean all