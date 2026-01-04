# WEB25 — PHP + MySQL web app

This repository contains a small PHP/MySQL/HTML project. Below are quick setup and run instructions for local development.

## Project Overview

**UniMatch** is a university social network platform designed to connect students and facilitate collaboration across campus. The application provides a comprehensive ecosystem where students can create and manage accounts, build their digital profiles, and discover peers with shared academic interests. Through the post creation feature, users can share their projects, ideas, and seek collaborators organized by course, making it easy to find fellow students working in similar areas.

Communication lies at the heart of the platform with a real-time chat system enabling direct messaging between users for seamless collaboration and networking. To maintain a safe and welcoming community, the platform includes a robust admin dashboard with comprehensive moderation tools that allow administrators to manage users, moderate post content, and handle user reports efficiently.

The entire experience is built with modern web standards, featuring a responsive design that works seamlessly across devices and an intelligent theme system that automatically adapts to user preferences with light, dark, and auto modes. The interface emphasizes minimalism and clarity, with smooth transitions and rounded components that create an intuitive and visually appealing user experience.

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
