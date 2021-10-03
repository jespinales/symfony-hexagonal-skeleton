
Required:
- php ^8.0
- Composer

Get starter:
- run: php -S localhost:8000 -t src/Infrastructure/Delivery/Api/Symfony/public

End points:
- GET localhost:8000/user

- POST localhost:8000/user
  - Params: 
    - name
    - email
  - Body: JSON
- GET localhost:8000/user/{id}
- DELETE localhost:8000/user/{id}