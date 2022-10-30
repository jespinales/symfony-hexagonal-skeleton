This project has been tested on a Xampp server

Required:
- PHP ^8.0
- Composer
- MariaDB ^10.4
- Apache ^2.4

Get starter: 
- Copy the example-apache-vhost.conf file to your Apache's vhost file. If necessary modify the path to your project and the name of your server
- Access localhost:8000

End points:
- curl --location --request GET 'localhost:8000/api/es/user?page=1&perPage=15'
- curl --location --request POST 'localhost:8000/api/es/user' \
  --header 'Content-Type: application/json' \
  --data-raw '{
  "name":"John Doe",
  "email":"Johndoe@outlook.com"
  }'
- curl --location --request DELETE 'localhost:8000/api/es/user/f81c9f80-478f-11ed-84b8-9828a634c4db'

Tests
- ./vendor/bin/phpunit tests/.