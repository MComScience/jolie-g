cp .env.dist .env
php init --env=Development --overwrite=All
php composer install