Build the MySQL Database and the Backend with the included Docker container using the provided `docker-compose.yml` file:

```bash
docker-compose up -d
```

### Install Dependencies

Install the required PHP packages via Composer:

```bash
composer install
```

### Environment Configuration

Use `_test_bootstrap.php` in `boostrap.php`if you want to run locally

Or add you Mysql in the .env file while importing `_dev_bootstrap.php` in `boostrap.php`

```env
MYSQL_PASSWORD="my_password"
MYSQL_USER="root"
MYSQL_DB="my_db"
MYSQL_HOST="host"
MYSQL_PORT=3306
TEST_ENV="THIS IS TEST VALUE"
```

### Database Migration

Since this project utilizes **Doctrine ORM**, you need to initialize the schema and run migrations to set up your tables:

```bash
php vendor/bin/doctrine-migrations migrations:migrate
```

---

## PROJECT STRUCTURE

- **`src/GraphQL`**: Contains the Schema definition, Query types, and Mutation types using `webonyx/graphql-php`.
- **`src/Entities`**: Doctrine ORM entities representing the database schema.
- **`public/index.php`**: The entry point of the application, utilizing `Bramus/Router` to handle incoming requests.

---

## USAGE

### Running the Server on Dev Mode

You can use the built-in PHP server for local development (you can change scripts on `composer.json`):

```bash
composer run dev
```

### API Endpoint

The GraphQL API is accessible via a `POST` request to:
`http://localhost:8080/graphql`

### Example Query

```graphql
query {
  products(category: "clothes") {
    id
    name
    price
    category
  }
}
```

---

## CACHING

This project implements `symfony/cache` to optimize metadata and query performance. To clear the cache during development:

```bash
rm -rf var/cache/*
```

---

By B.chirani
