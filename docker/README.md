
## 安裝 Docker-ce
請先參閱docker安裝說明依照系統與需求安裝Docker-ce
安裝說明 [https://docs.docker.com/install/](https://docs.docker.com/install/)


## 安裝portainer docker管理介面(選用)
此套件用於方便管理Docker，若有其他慣用套件可忽略安裝此套件。
相關說明可參考 [https://portainer.io/](https://portainer.io/)
```
mkdir -p /usr/local/yda/portainer
docker run -d -p 9000:9000 -name portainer --restart always -v /var/run/docker.sock:/var/run/docker.sock -v /usr/local/yda/portainer:/data portainer/portainer
```

## 安裝Nginx reverse proxy
```
mkdir -p /usr/local/yda/nginx
docker run --name tmp-nginx-container -d nginx
docker cp -a tmp-nginx-container:/etc/nginx/* /usr/local/yda/nginx/*
docker rm -f tmp-nginx-container
docker network create nginx --attachable
docker run --name nginx-reverse_proxy --network=nginx -p 80:80 -p 443:443  --restart always -v /usr/local/yda/nginx:/etc/nginx -v /etc/pki/tls/certs/advisory.yda.gov.tw.crt:/etc/pki/tls/certs/advisory.yda.gov.tw.crt -v /etc/pki/tls/private/server2.key:/etc/pki/tls/private/server2.key -d nginx
```


## 額外安裝必要套件
 - pwgen (密碼產生器)
 - docker-compose (docker compose必要套件)

## 安裝青諮網站docker container
安裝所需檔案清單

 - create_yda_docker.sh (安裝主要腳本)
 - docker-compose.yml (docker container 相依套件compose腳本)
 - dockerfile (docker container 青諮網站container主要腳本)
 - docker-oc-entrypoint (docker container 青諮網站container相依腳本)
 - env.example (環境變數主要腳本範例)
 - env.template (環境變數主要腳本)

請先將env.example改名成env.template  
請確認修改完成env.template到所需參數，請勿修改DB_前綴之資料庫相關參數  

如需新增第一屆請將${SESSION_NUMBER}改為數字1  
例如：./create_yda_docker.sh 1  
依此類推，最多新增99屆  
```
./create_yda_docker.sh ${SESSION_NUMBER}
```
