# Installing PHP and the Laravel Installer

## Step 1: Install PHP (Windows)

Run as **Administrator** in Windows PowerShell:

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
```

After running one of the commands above, you should restart your terminal session. To update PHP, Composer, and the Laravel installer after installing them via php.new, you can re-run the command in your terminal.

You can also check Laravel's doc for other means of installation

If you already have PHP and Composer installed, you may install the Laravel installer via Composer:

```bash
composer global require laravel/installer
```

## ⚙️ Installation

### 1️⃣ Clone the repository

```bash
git clone https://github.com/Movved/PFE-ESTO.git
cd PFE-ESTO
```

---

### 2️⃣ Install dependencies

```bash
composer install
npm install
```

## Run the Development Environment
You can start Laravel's local development server, queue worker, and Vite development server using the `dev` Composer script:

```bash
cd pfe-app
npm install && npm run build
composer run dev
```
### 3️⃣ Navigate to the Laravel app

```bash
cd pfe_app
```

---

### 4️⃣ Install Node dependencies

```bash
npm install
```

---

### 5️⃣ Environment Setup

Copy the environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Edit `.env` and configure your database if it happens to be different:

```
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---



## Environment Configuration

`.env` was modified to suit XAMPP's settings.

XAMPP has the tables.

---
### 6️⃣ Database Setup

Don't Run migrations yet:

```bash
php artisan migrate
```

Instead in your xampp run the commands in 
## Database Seeding

We used seeders to fill the tables.

The test data is located in:

```
pfe-app\database\seeders\DatabaseSeeder.php
```

Run the following command to seed the database:

```bash
php artisan db:seed
```

### 7️⃣ Run the Application

Build frontend assets:

```bash
npm run dev
```

Start the Laravel development server:

```bash
php artisan serve
```

Open in browser:

```
http://localhost:8000
```

