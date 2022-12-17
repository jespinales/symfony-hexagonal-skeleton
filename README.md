
# Simfony Hexagonal Skeleton

This is a small template on how to implement symfony with hexagonal architecture.

This project has been tested on Windows with Xampp. If you are testing on Linux, you should adjust the vhost file paths.

## Requires

- PHP ^8.0
- Composer
## Tested on

- Xampp 8.0.23-0
## Run Locally

Clone the project

```bash
  git clone https://github.com/jespinales/symfony-hexagonal-skeleton
```

Go to the project directory

```bash
  cd symfony-hexagonal-skeleton
```

Install dependencies

```bash
  composer install
```

Copy the contents of the example-apache-vhost.conf file to the Apache vhost file. If necessary modify the path to your project and the name of your server

Access localhost:8000


## Running Tests

To run tests, run the following command

```bash
  ./vendor/bin/phpunit tests/.
```


## API Reference

#### Get paginated items

```http
  GET /api/es/users
```

| Parameter | Type     | Description                                   |
| :-------- | :------- | :-------------------------------------------- |
| `page`    | `int`    | **Nullable**. Page number                     |
| `perPage` | `int`    | **Nullable**. Items to display for each page  |

#### Register user

```http
  POST /api/es/users
```

| Parameter  | Type     | Description                       |
| :--------- | :------- | :-------------------------------- |
| `name`     | `string` | **Required**. User name           |
| `email`    | `string` | **Required**. User email          |
| `password` | `string` | **Required**. User password       |

#### Delete user

```http
  DELETE /api/es/users/{id}
```

| Parameter  | Type     | Description                                |
| :--------- | :------- | :----------------------------------------- |
| `id`       | `string` | **Required**. Id of the user to be removed |

#### Login user

```http
  POST /api/es/auth/login
```

| Parameter  | Type     | Description                                |
| :--------- | :------- | :----------------------------------------- |
| `email`    | `string` | **Required**. Id of the user to be removed |
| `password` | `string` | **Required**. User password