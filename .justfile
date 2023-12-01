@default:
	just --list

@check: check-php

@check-php: install-php
	vendor/bin/pest --parallel --exclude-group integration
	vendor/bin/php-cs-fixer fix --allow-risky=yes --config .php-cs-fixer.php --diff --dry-run --verbose app/ config/ database/ public/ resources/ routes/ tests/

@install: install-php

@install-php:
	composer install

@watch-php-tests *FLAGS: install-php
	watchexec -c -e php -i **/storage/framework/**/* -- vendor/bin/pest --parallel --exclude-group integration {{FLAGS}}

@watch-active-php-tests *FLAGS: install-php
	watchexec -c -e php -i **/storage/framework/**/* -- vendor/bin/pest --compact --group active {{FLAGS}}
	
@watch-dirty-php-tests *FLAGS: install-php
	watchexec -c -e php -i **/storage/framework/**/* -- vendor/bin/pest --compact --dirty {{FLAGS}}
