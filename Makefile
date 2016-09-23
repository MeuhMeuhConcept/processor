.PHONY: help unitTest test, cs-check, cs-fix
bin_dir=vendor/bin

vendor/autoload.php:
	composer install

unitTest: vendor/autoload.php ## Run unit tests
	${bin_dir}/phpunit

test: unitTest ## Run tests

cs-check: vendor/autoload.php ## Check PHP CS
	${bin_dir}/php-cs-fixer --version
	${bin_dir}/php-cs-fixer fix -v --diff --dry-run

cs-fix: vendor/autoload.php ## Fix PHP CS
	${bin_dir}/php-cs-fixer --version
	${bin_dir}/php-cs-fixer fix -v --diff

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help