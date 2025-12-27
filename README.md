# WEB25 — PHP + MySQL web app

This repository contains a small PHP/MySQL/HTML project. Below are quick setup and run instructions for local development.

## Requirements
- PHP 8+ with `mysqli` extension
- MySQL or MariaDB server
- Web browser

## Setup
1. Configure DB credentials: edit [config/database.php](config/database.php) and set `host`, `user`, `pass`, `dbname`, `port` if needed.

2. Import schema and seed data (run from project root):
```bash
mysql < resources/database.sql
mysql < resources/demo.sql
```

3. Start built-in PHP server (from project root):
```bash
php -S localhost:8000 -t src/public
```

4. Open in browser:
http://localhost:8000/
