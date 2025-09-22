Infoshop – PHP/Apache Web Application

## Overview
A fully deployable apache / php web application that serves as an online shop for it and gaming products.
Full with database example and websocket server.

## Features
- User registration/login
- Product catalog with search & filter
- Shopping cart & checkout
- Admin dashboard for product management
- Realtime chat for customer support via websockets

## Tech Stack
- **Backend:** PHP 8.x
- **Web Server:** Apache 2.4
- **Database:** MySQL/MariaDB
- **Frontend:** HTML5, CSS3, JavaScript, EJS)
- **Other:** Composer, Socket.io

## Requirements
- PHP 8.x or later
- Apache 2.4+
- MySQL/MariaDB
- Composer
- Git (optional)

## Installation

Download xampp.

Replace /htdocs with the project root folder.

Start xampp -> Apache and MySQL

localhost/phpmyadmin -> Create database "infoshop" --> then import from infoshop.sql in /backup

Download ngrok
Open ngrok cmd -> ngrok http 80


In visual studio terminal: cd server -> php server.php for Websocket server.

Open cmd 
npm install -g localtunnel
lt --port 8080 --subdomain infoshopws
