#!/bin/bash
export YDA_SESSION=$(printf "%02d" $1)
export YDA_SESSION_NAME=yda-$YDA_ALIAS_$YDA_SESSION
export YDA_DIR=/usr/local/yda/session
export YDA_ALIAS_DIR=$YDA_DIR/$YDA_SESSION_NAME
export RND_PASS=$(pwgen -s 20)

if [ $YDA_SESSION == "00" ]; then
    echo "Session Number must greater than 1"
    exit 1
fi

if [ -d $YDA_ALIAS_DIR ]; then
    echo "docker volume $YDA_ALIAS_DIR exist abort create action"
    exit 1
fi

docker network ls | grep host > /dev/null
if [ $? -eq 1 ]; then
    echo "docker network nginx not exist. please create first"
    exit 1
fi


echo "Perpare persistent folders"
mkdir -p $YDA_ALIAS_DIR
mkdir -p $YDA_ALIAS_DIR/storage
mkdir -p $YDA_ALIAS_DIR/storage/app
mkdir -p $YDA_ALIAS_DIR/storage/logs

echo "Perpare persistent files"
touch $YDA_ALIAS_DIR/storage/database.sqlite
cp env.template $YDA_ALIAS_DIR/.env
cp docker-compose.yml $YDA_ALIAS_DIR/docker-compose.yml

cd $YDA_ALIAS_DIR
echo "adjust compose variable"
sed -i "s/expose_web_port/80$YDA_SESSION/g" docker-compose.yml
sed -i "s/sql_password/$RND_PASS/g" docker-compose.yml
sed -i "s/sql_password/$RND_PASS/g" .env
sed -i "s/^\(APP_KEY=\).*/\1$(pwgen -s 32)/" .env

echo "build dockers"
docker-compose build
docker-compose up -d

echo "Waiting 15 second for MySQL Service is Active...."
sleep 15

echo "run post command"
docker-compose exec web mkdir -p /var/www/html/storage/app/media
docker-compose exec web touch -d '1 Jan 2018 00:00' /var/www/html/storage/app/media/gpvip.csv
docker-compose exec web chown -R www-data:www-data /var/www/html
docker-compose exec web php artisan october:up
docker-compose exec web php artisan theme:use responsiv-flat-test
docker-compose exec web php artisan key:generate
docker-compose exec web php artisan config:clear
docker-compose exec web php artisan config:cache
docker-compose exec web php artisan cache:clear
docker network connect nginx $YDA_SESSION_NAME-web
