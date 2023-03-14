# symf_docker
Create project:
<ul>
  <li>docker exec www_docker_symfony composer create-project symfony/website-skeleton project</li>
</ul>

change file .env :
  DATABASE_URL=mysql://root:@db_docker_symfony:3306/db_name?serverVersion=5.7
docker exec -it www_docker_symfony bash
cd project
php bin/console doctrine:database:create

symfony: http://localhost:8741
phpmyadmin:http://localhost:8080

