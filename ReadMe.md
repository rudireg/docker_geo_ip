### Развернуть проект.
`docker-compose -f docker-compose.dev.yml up -d`
### Установить приложения через Composer
`docker-compose -f docker-compose.dev.yml run --rm php composer install`
### Развернуть Базу данных (Postgres)

Создать базу данных postgres под именем `restapi`

`docker-compose -f docker-compose.dev.yml run --rm php bin/console doctrine:migrations:migrate`

## Функционал

Проверка Гео данных IP адреса.

1) Через форму на странице http://localhost:10502/

2) Запуск по крону. Команда для крона (запуск каждый день в полночь)

    `CRON: 0 0 * * * /app/bin/console app:rebuild_geo_ip`
    
3) Ручной запуск через Docker команду

`docker exec -it container_id php /app/bin/console app:rebuild_geo_ip`
   
    





