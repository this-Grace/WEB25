# WEB25 — PHP + MySQL web app

This repository contains a small PHP/MySQL/HTML project. Below are quick setup and run instructions for local development.

## Quick Start (Local Development)

- **Prerequisites**: PHP 7.4+ (with PDO MySQL), MySQL or MariaDB, and a terminal.
- **Project root**: run commands from the repository root (the folder that contains `public` and `src`).

### 1) Database
- Create a database and import any available SQL dump. Update the database credentials in [src/database.php](WEB25/src/database.php) before running.

Example import:
```bash
mysql < resources/databse.sql
mysql < resources/demo.sql
```

### 2) Configure
- Open [app/bootstrap.php](WEB25/app/bootstrap.php) and set `host`, `username`, `password`, and `dbname` to match your local database.

### 3) Run (built-in PHP server)
- From the project root run:
```bash
php -S localhost:8000 -t public
```
- Then open http://localhost:8000 in your browser.

### 4) Run with Docker (recommended)

You can run the app + MySQL using Docker Compose. Create a `docker-compose.yml` in the project root with the following content (or copy/paste into your CI/deploy):

```yaml
version: '3.8'

services:
	web:
		build: .
		ports:
			- "4567:80"
		depends_on:
			- db
		environment:
			DB_HOST: db
			DB_USER: root
			DB_PASSWORD: example
			DB_NAME: web25
			DB_PORT: 3306
		volumes:
			- ./:/var/www/html:delegated
		restart: unless-stopped

	db:
		image: mysql:8.0
		environment:
			MYSQL_ROOT_PASSWORD: example
			MYSQL_DATABASE: web25
		volumes:
			- db_data:/var/lib/mysql
			- ./resources/database.sql:/docker-entrypoint-initdb.d/init.sql:ro
		ports:
			- "3306:3306"
		restart: unless-stopped

volumes:
	db_data:

```

Start the stack:

```bash
docker-compose up --build -d
```

Web: http://localhost:4567

Importing demo data:
- If the DB volume is empty the `resources/database.sql` will be executed at first start.
- To import `resources/demo.sql` into a running DB container:

```bash
docker exec -i $(docker-compose ps -q db) mysql -u root -pexample web25 < resources/demo.sql
```

Notes:
- Adjust ports and passwords before deploying to production.
- If you want automatic image updates, consider publishing the image to a registry and using `watchtower` or a CI/CD deploy step.
