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

You can run the app + MySQL using Docker Compose. For production we provide `docker-compose.yml` which pulls the image from GHCR. Example `docker-compose.yml` (already in this repo):

```yaml
services:
  web:
    image: ghcr.io/this-Grace/web25:latest
    ports:
      - "4567:80"
    environment:
      DB_HOST: db
      DB_USER: root
      DB_PASSWORD: example
      DB_NAME: web25
      DB_PORT: 3306
    volumes:
      - ./upload:/var/www/html/upload:delegated
    restart: unless-stopped
    depends_on:
      db:
        condition: service_healthy

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
    healthcheck:
      test: ["CMD-SHELL", "mysqladmin ping -h localhost -uroot -p$MYSQL_ROOT_PASSWORD >/dev/null 2>&1"]
      interval: 10s
      timeout: 5s
      retries: 10

  # Watchtower keeps services up-to-date by pulling new images from the registry
  watchtower:
    image: containrrr/watchtower:latest
    volumes:
      - /var/run/docker.sock:/var/run/docker.sock
    command: --interval 300 --cleanup
    restart: unless-stopped

volumes:
  db_data:

```

Start the stack (production file):

```bash
docker-compose -f docker-compose.prod.yml up -d
```

Web: http://localhost:4567

Importing demo data:
- If the DB volume is empty the `resources/database.sql` will be executed at first start.
- To import `resources/demo.sql` into a running DB container:

```bash
docker exec -i $(docker-compose -f docker-compose.prod.yml ps -q db) mysql -u root -pexample web25 < resources/demo.sql
```

Notes:
- Adjust ports and passwords before deploying to production.
- If you want automatic image updates, consider publishing the image to a registry and using `watchtower` or a CI/CD deploy step.
