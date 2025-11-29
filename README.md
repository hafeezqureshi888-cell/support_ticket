# Support Ticket System

A robust support ticket management system built with Laravel. This application handles ticket submissions, tracking, and management across multiple departments using a multi-database architecture.

## Features

-   **Multi-Department Support**: Separate databases for Technical, Billing, Product, General, and Feedback departments.
-   **Ticket Management**: Create, view, and track support tickets.
-   **Email Notifications**: Automated email confirmations for ticket submissions.
-   **Admin Panel**: Dashboard for managing tickets.
-   **Automated Setup**: Custom Artisan command for easy project initialization.

## Prerequisites

Before you begin, ensure you have the following installed:

-   [PHP](https://www.php.net/downloads) (>= 8.2)
-   [Composer](https://getcomposer.org/download/)
-   [MySQL](https://dev.mysql.com/downloads/installer/) (or MariaDB)
-   [Node.js & NPM](https://nodejs.org/) (for frontend assets)

## 🛠️ Installation & Setup

Follow these steps to set up the project on your local machine.

### 1. Clone the Repository

```bash
git clone <repository-url>
cd support_ticket
```

### 2. Install Dependencies

Install PHP and Node.js dependencies:

```bash
composer install
npm install
```

### 3. Configure Environment

1.  Copy the example environment file (if not already done):

    ```bash
    cp .env.example .env
    ```

2.  **CRITICAL**: Open the `.env` file and configure your database and email settings.

    **Database Configuration:**

    ```env
    DB_CONNECTION=mysql
    # DB_HOST=127.0.0.1
    # DB_PORT=3306
    # DB_DATABASE=support_system
    # DB_USERNAME=root
    # DB_PASSWORD=
    ```

    **Email Configuration (Gmail Example):**

    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=your_email@gmail.com
    MAIL_PASSWORD=your_app_password  <-- Use an App Password, not your login password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=your_email@gmail.com
    ```

### 4. Automated Setup (Database & Migrations)

We have created a custom command to automate the database creation and migration process for all departments.

Run the following command:

```bash
php artisan app:setup
```

**What this command does:**

-   Checks if `.env` exists (copies it if missing).
-   Generates the application key.
-   **Creates all required databases** automatically (`support_system`, `support_technical`, `support_billing`, etc.).
-   **Runs migrations** for all database connections.

### 5. Seed the Database

Populate the database with initial data (test users, tickets, etc.):

```bash
php artisan db:seed
```

**Default Login Credentials:**
- **Email:** `admin@example.com`
- **Password:** `password`

### 6. Build Frontend Assets

Compile the CSS and JavaScript assets:

```bash
npm run build
```

### 7. Run the Application

Start the local development server:

```bash
php artisan serve
```

Access the application at: `http://localhost:8000`

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
