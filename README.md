# Laravel 11 Travel Blog

A full‑featured travel blog platform built with **Laravel 11**, allowing admins to manage blog posts while offering users interactive features like commenting, favoriting, and post notifications.

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
  - [Database Setup](#database-setup)
  - [Running the App](#running-the-app)
- [Usage](#usage)
- [Admin Dashboard](#admin-dashboard)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

---

## Features

- Admin management of blog posts (create, edit, delete)
- Visitor commenting system
- Post favoriting
- Instant post notifications (e.g., via email or in-app)
- User registration and authentication

---

## Tech Stack

- **Backend**: PHP 8.2+, **Laravel 11**
- **Frontend**: Blade templates, Tailwind CSS/Vite, JavaScript
- **Database**: MySQL (configurable via `.env`)
- **Notifications**: Laravel Notifications (email, database)

---

## Getting Started

### Prerequisites

Ensure you have:

- PHP 8.2 or newer
- Composer
- Node.js & npm
- MySQL or similar
- Docker (optional)

### Installation

```bash
git clone https://github.com/mshayanamjad/laravel-11-travel-blog.git
cd laravel-11-travel-blog
cp .env.example .env
composer install
npm install
npm run dev  # or npm run build for production
php artisan key:generate
```

### Database Setup

Update your `.env` with database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=travel_blog_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Then run migrations and seeders (if available):

```bash
php artisan migrate --seed
```

### Running the App

Without Docker:

```bash
php artisan serve
```

Visit `http://localhost:8000`

---

## Usage

- Readers can browse posts, comment, and favorite posts (after authentication).
- Admins create and manage blog content via admin dashboard.

---

## Admin Dashboard

Access via a route like `/admin` (modify according to your setup).  
Ensure an admin user exists—log in or register with admin privileges.

---

## Testing

Run tests with:

```bash
php artisan test
```

---

## Contributing

1. Fork the repo
2. Create a branch (`git checkout -b feature/YourFeature`)
3. Commit your changes (`git commit -m "Add feature"`)
4. Push branch and open a pull request

---

## License

Open-source, MIT License (see [LICENSE](LICENSE) file)

---

## Contact

Maintainer: **mshayanamjad**  
**GitHub Profile**: [mshayanamjad](https://github.com/mshayanamjad)

---
