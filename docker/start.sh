echo "Start checking migrate"
./docker/wait-for-it.sh db:3306 -- php artisan migrate:install | grep -q "created" && php artisan migrate:fresh --seed
php artisan serve --port 9000 --host 0.0.0.0