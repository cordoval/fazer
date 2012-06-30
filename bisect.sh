rm -rf vendor
rm composer.lock
composer install
phpunit -c phpunit.xml.dist
