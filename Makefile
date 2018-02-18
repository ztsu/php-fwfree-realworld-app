COMPOSER=
COMPOSER-EXISTS:=$(shell command -v composer 2> /dev/null)
COMPOSER-LOCAL-EXISTS:=$(shell command -v ./composer.phar 2> /dev/null )

ifdef COMPOSER-EXISTS
COMPOSER=$(COMPOSER-EXISTS)
else ifdef COMPOSER-LOCAL-EXISTS
COMPOSER=$(COMPOSER-LOCAL-EXISTS)
endif

install: composer
	$(COMPOSER) install

run:
	php -S 0.0.0.0:8000 -t public/ public/index.php

composer:
ifndef COMPOSER
	@read -p "Install composer locally? [y/N]" a; case $$a in y|Y) make install-composer;; *) exit;; esac ;
COMPOSER=./composer.phar
endif

install-composer:
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	php composer-setup.php
	php -r "unlink('composer-setup.php');"

db:
	docker-compose -f docker-compose.yml up

test:
	vendor/bin/phpunit

testdox:
	vendor/bin/phpunit --testdox

coverage:
	vendor/bin/phpunit --coverage-clover=coverage.xml
