.PHONY: help     # Generate list of targets with descriptions
help:
	@echo "\n"
	@grep '^.PHONY: .* #' Makefile | sed 's/\.PHONY: \(.*\) # \(.*\)/\1 \2/' | expand -t20


.PHONY: test            # Runs unit tests on host machine with PHP 7.1+
test:
	./bin/phpunit --coverage-clover=coverage.xml

.PHONY: install         # Installs PHP dependencies
install:
	composer install

.PHONY: docker-up       # Starts the PHP Container
docker-up:
	docker-compose -f build/docker/docker-compose.yml up -d

.PHONY: docker-down    # Shuts down the PHP Container
docker-down:
	docker-compose -f build/docker/docker-compose.yml down

.PHONY: docker-test # Runs unit tests inside the PHP Container
docker-test:
	docker-compose -f build/docker/docker-compose.yml exec php bash -c "composer install && ./bin/phpunit --coverage-html 'tests/coverage' --coverage-clover=tests/coverage.xml"
