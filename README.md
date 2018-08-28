# Run youth-concil web by docker

docker run -p 80:80 --rm --name youth-concil \
-v $(pwd)/plugins:/var/www/html/plugins \
-v $(pwd)/themes:/var/www/html/themes \
-v $(pwd)/env:/var/www/html/.env \
aspendigital/octobercms:latest