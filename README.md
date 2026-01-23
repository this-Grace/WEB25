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
