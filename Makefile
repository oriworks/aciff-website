.PHONY: run
run:
	@docker compose up -d --remove-orphans

.PHONY: stop
stop:
	@docker compose down