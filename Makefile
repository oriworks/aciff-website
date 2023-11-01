.PHONY: install
install:
	@docker compose run composer

.PHONY: run
run:
	@docker compose up --build -d --remove-orphans

.PHONY: stop
stop:
	@docker compose down