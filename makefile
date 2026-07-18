.PHONY: install run analyse telescope

install:
    composer install

run:
    php artisan serve --host=localhost --port=8000

analyse:
    php -d memory_limit=512M ./vendor/bin/phpstan analyse app


test:
    php artisan test