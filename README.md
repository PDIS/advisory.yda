# Run youth-concil web by docker-compose

```
docker-compose up
docker-compose exec web php artisan october:up
docker-compose exec web php artisan theme:use responsiv-flat-test
docker-compose exec web chown www-data:www-data /var/www/html/storage/logs/system.log
```