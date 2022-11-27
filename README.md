
<h1 align="center">
  cloud-storage-api
  <br>
</h1>

<h4 align="center"> Прототип сервиса облачного хранилища для файлов </h4>


<p align="center">
  <a href="#описание">Описание</a> •
  <a href="#как-скачать">Как скачать</a>
</p>

## Описание



* Сервис предоставляет хранение файлов и возможность делится ими с другими, указывая срок хранения по истечению которого
  файл удалится автоматически
* Максимальный объём одного загружаемого файла 20мб, 100мб всего на диске пользователя, файл не может иметь расширение .php
* Пользователь может удалять, переименовывать, и просматривать свои файлы и создавать папки
* Пользователь может получить размер всех файлов внутри директории и размер всех файлов на диске

## Как скачать

Скопируем env.example в корень и переименуем в .env, указываем тип бд и если нужно порт, в APP_URL вписываем хост сайта.
И запускаем следующие команды:
```bash
# Качаем зависимости
$ composer install

# Поднимаем контейнеры
$ ./vendor/bin/sail up

# Установка ключа приложения
$ php ./vendor/bin/sail artisan key:generate

# Запускаем миграции
$ ./vendor/bin/sail artisan migrate

# Линкуем папки
$ ./vendor/bin/sail artisan storage:link

# Набираем команду
$ crontab -e
# и вставляем это
# * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1 
```
## Последовательность



* GET http://62.217.178.207/sanctum/csrf-cookie - получаем XSRF TOKEN, должен отправляться со всеми запросами
* POST http://62.217.178.207/register - регистрируем пользователя, параметры:
    * name 
    * email 
    * password 
    * password_confirmation 
* POST http://62.217.178.207/login - логинемся, параметры:
    * email
    * password
* POST http://62.217.178.207/api/directory/create - создание директории, параметры:
    * title
* POST http://62.217.178.207/api/file/upload - загрузка файла, параметры:
    * file
    * file_retention_period_at
    * directory_id
* GET http://62.217.178.207/api/file/index - список файлов.
* PATCH http://62.217.178.207/api/file/rename/{fileID} - переиминовать файл, параметры:
    * file_name
* GET http://62.217.178.207/api/file/download/{fileID} - скачивание файла
* GET http://62.217.178.207/api/file/size-in-directory/{directoryID} - размер всех файлов внутри директории
* GET http://62.217.178.207/api/file/size-on-disk - размер всех файлов на диске
* DELETE http://62.217.178.207/api/file/delete/{fileID} - удаление файла
* POST http://62.217.178.207/api/file/links/{fileId} - сделать публичную ссылку на файл
* GET http://62.217.178.207/api/file/links/8 - получение публичгой ссылки, параметры:
    * token
