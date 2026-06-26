<div align="center">

# 🏨 Hotel Management System

Modern Hotel Management System built with Laravel, MySQL, Tailwind CSS and AJAX.

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8+-blue)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4)
![AJAX](https://img.shields.io/badge/AJAX-Enabled-yellow)
![SMTP](https://img.shields.io/badge/SMTP-Gmail-EA4335)
![PayHere](https://img.shields.io/badge/PayHere-Sandbox-00A859)
![License](https://img.shields.io/badge/License-Educational-green)
![GitHub last commit](https://img.shields.io/github/last-commit/Lakiindu/hotel-management-system)
![GitHub repo size](https://img.shields.io/github/repo-size/Lakiindu/hotel-management-system)
</div>

# 🏨 Hotel Management System

A modern Hotel Management System built using **Laravel 12**, **PHP**, **MySQL**, **Tailwind CSS**, **AJAX**, **JavaScript**, **Google SMTP Email Services** and **PayHere Sandbox Payment Gateway**.

The system provides a complete solution for hotel operations including room management, bookings, secure online payments, automated email notifications, customer management, reviews, reports and dynamic website content management through dedicated **Admin** and **Customer** panels.

---

# 📌 Project Overview

The Hotel Management System is designed to simplify hotel operations and improve the customer booking experience.

### Main Objectives

- Manage hotel rooms and availability
- Handle room bookings efficiently
- Manage customer information
- Process and track payments
- Manage customer reviews and feedback
- Manage hotel website content dynamically
- Generate reports for administrators

---

# 🚀 Technologies Used

## Backend

- Laravel 12
- PHP 8+
- MySQL
- Google SMTP (Gmail)
- PayHere Sandbox Payment Gateway

## Frontend

- Blade Templates
- Tailwind CSS
- JavaScript
- AJAX

## Development Tools

- Visual Studio Code
- Git & GitHub
- Composer
- WAMP Server
- ngrok (Local PayHere Callback Testing)

---

# 👥 User Roles

## Admin

Administrators can:

- Manage Rooms
- Manage Bookings
- Manage Customers
- Manage Payments
- Manage Reviews
- Manage Contact Messages
- Generate Reports
- Manage Homepage Content
- Manage Hotel Services
- Manage Gallery Images

## Customer

Customers can:

- Register and Login
- Browse Available Rooms
- View Room Details
- Make Room Bookings
- Manage Bookings
- Secure Card Payments via PayHere
- Cash Payment Option
- Submit Reviews
- Manage Profile Information
- Download Invoices

---

# 🌐 Public Website Features

## Home Page

- Hero Section
- About Section
- Featured Rooms
- Hotel Services
- Gallery Showcase
- Contact Section
- Dynamic Content Management

## Rooms

- View Available Rooms
- View Room Details
- Pricing Information
- Room Images

## Services

- Hotel Facilities Showcase
- Dynamic Service Management

## Gallery

- Hotel Image Gallery
- Dynamic Gallery Management

## Contact

- Customer Contact Form
- Message Management for Administrators

---

# ⚙️ Admin Panel Features

## Room Management

- Add Rooms
- Edit Rooms
- Delete Rooms
- Manage Availability

## Booking Management

- View Bookings
- Approve Bookings
- Cancel Bookings
- Update Booking Status

## Customer Management

- View Customer Information
- Manage Customer Accounts

## Payment Management

- PayHere Payment Monitoring
- Cash Payment Confirmation
- Automatic Card Payment Verification
- Payment History
- PDF Invoice Generation
- CSV Invoice Export
- Customer Payment Tracking

## Website Content Management

### Home Content Management

- Hero Section
- About Section
- Mission Section
- Vision Section
- Contact Information
- Footer Content

### Service Management

- Add Services
- Edit Services
- Upload Service Images

### Gallery Management

- Upload Gallery Images
- Categorize Images
- Manage Gallery Visibility

---

# 📊 System Modules

- Authentication & Authorization
- Room Management
- Booking Management
- Customer Management
- Payment Gateway Integration
- Invoice Management
- Email Notification System
- Review Management
- Contact Management
- Notification System
- Reports Module
- Home Content Management
- Service Management
- Gallery Management

---

# 🗄️ Database Tables

The system uses MySQL and includes tables such as:

- users
- rooms
- bookings
- payments
- reviews
- contact_messages
- notifications
- services
- galleries
- hotel_contents

---

# 🔧 Installation Guide

## Clone Repository

```bash
git clone https://github.com/Lakindu/hotel-management-system.git
```

## Navigate to Project

```bash
cd hotel-management-system
```

## Install Dependencies

```bash
composer install
```

## Create Environment File

```bash
cp .env.example .env
```

## Generate Application Key

```bash
php artisan key:generate
```

## Configure Database

Update your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_management
DB_USERNAME=root
DB_PASSWORD=
```

## Configure SMTP

Update your `.env` file with your Gmail SMTP credentials.

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="RoyalStay Hotel"
```

## Configure PayHere
```env
PAYHERE_MERCHANT_ID=your_merchant_id
PAYHERE_MERCHANT_SECRET=your_merchant_secret
PAYHERE_SANDBOX=true
```

## Run Database Migrations

```bash
php artisan migrate
```

## Create Storage Link

```bash
php artisan storage:link
```

## Start Development Server

```bash
php artisan serve
```

Visit:

```text
http://127.0.0.1:8000
```

---

# 📂 Project Structure

```text
app/
├── Http/
├── Models/

database/
├── migrations/

resources/
├── views/
│   ├── admin/
│   ├── customer/
│   └── frontend/

routes/
├── web.php

public/
storage/
```


---

# 👨‍💻 Developer

**Lakindu Ransika**

Hotel Management System developed as a Full Stack Laravel Web Application using Laravel, MySQL, Tailwind CSS, AJAX, and JavaScript.

---

# 📄 License

This project is developed for educational and portfolio purposes.

---

⭐ If you found this project useful, consider giving it a star on GitHub.
