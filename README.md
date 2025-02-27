## Glass Cannon Unplugged Recruitment Task

# Tech stack
Backend: Laravel 12, PHP 8.3
Front: Vue 3, Inertia 2, shadcn-vue, TailwindCSS
Tools/bundlers: Vite, Prettier, Eslint 

# Project setup guide

## System Requirements
- PHP 8.3+
- Comoposer
- Node.js 16+ & NPM (or Yarn, whatever)
- MySQL/PostgreSQL (or your preferred database)

## Option 1: Launch with Laravel Herd (macOS)

[Laravel Herd](https://herd.laravel.com/) provides a simple, native macOS development environment.

1. Install Laravel Herd from https://herd.laravel.com/
2. Clone the repository:
   ```
   git clone [repository-url]
   cd [project-directory]
   ```
3. Install PHP dependencies:
   ```
   composer install
   ```
4. Install frontend dependencies:
   ```
   npm install
   ```
5. Copy environment file and configure:
   ```
   cp .env.example .env
   ```
6. Generate application key:
   ```
   php artisan key:generate
   ```
7. Configure database settings in `.env` file
8. Run migrations:
   ```
   php artisan migrate
   ```
9. Seed the database with sample data (users and products):
   ```
   php artisan db:seed
   ```
10. Build frontend assets:
   ```
   npm run dev
   ```
10. Access the site at the URL provided by Herd (typically `http://project-name.test`)

## Option 2: Launch with PHP Development Server (Cross-platform)

This option works on macOS, Windows, and Linux.

1. Clone the repository:
   ```
   git clone [repository-url]
   cd [project-directory]
   ```
2. Install PHP dependencies:
   ```
   composer install
   ```
3. Install frontend dependencies:
   ```
   npm install
   ```
4. Copy environment file and configure:
   ```
   cp .env.example .env
   ```
5. Generate application key:
   ```
   php artisan key:generate
   ```
6. Configure database settings in `.env` file
7. Run migrations:
   ```
   php artisan migrate
   ```
8. Seed the database with sample data (users and products):
   ```
   php artisan db:seed
   ```
9. Build frontend assets (in one terminal):
   ```
   npm run dev
   ```
10. Start the PHP development server (in another terminal):
   ```
   php artisan serve
   ```
11. Access the site at `http://localhost:8000`

## Additional Notes

- Make sure your PHP version is 8.3 or higher
- For production deployment, use `npm run build` instead of `npm run dev` - dev creates hot directory in public, that needs to be deleted eventually.