# Blog API

## Installation

```
composer install
```

### Migrate Database

```
php artisan migrate
```

### Install Laravel Passport

```
php artisan passport:install
```

### Routes

```
+----------+--------------------------------+
 Method    | URI                            |
+----------+--------------------------------+
| POST     | api/login                      |
| POST     | api/logout                     |
| GET|HEAD | api/posts                      |
| POST     | api/posts                      |
| GET|HEAD | api/posts/{slug}               |
| PATCH    | api/posts/{slug}               |
| DELETE   | api/posts/{slug}               |
| GET|HEAD | api/posts/{slug}/comments      |
| POST     | api/posts/{slug}/comments      |
| PATCH    | api/posts/{slug}/comments/{id} |
| DELETE   | api/posts/{slug}/comments/{id} |
| POST     | api/register                   |
+----------+--------------------------------+
```