# Abalo

Abalo is a small marketplace application for discovering, listing, and organizing second-hand items. It started as a university web-development project and grew into a complete Laravel application with live search, category filters, article creation, and a persistent shopping cart.

## What you can do

- Browse a responsive product catalog
- Search for articles without reloading the page
- Filter articles by their real database categories
- Publish a new article with a price, description, and category
- Add and remove articles from the shopping cart

## Built with

- **Laravel 13** and **PHP 8.3+** for routing, validation, APIs, and database access
- **Vue 3** for live search and the article form
- **Vite 8** for frontend development and production builds
- **Tailwind CSS 4** with custom CSS for the interface
- **SQLite** by default for a quick local setup; Laravel also supports PostgreSQL
- **PHPUnit** for feature and unit tests

## Run it locally

You need PHP 8.3+, Composer, Node.js, and npm.

```bash
composer run setup
composer run dev
```

Then open [http://127.0.0.1:8000](http://127.0.0.1:8000).

The setup command installs dependencies, creates the local SQLite database, runs migrations, imports the included demo catalog, and builds the frontend.

## Useful commands

```bash
# Run the test suite
composer test

# Create a production frontend build
npm run build

# Reset and reload the demo database
php artisan migrate:fresh --seed
```

## Project structure

```text
app/                 Laravel controllers and models
database/            Migrations, demo CSV data, and database seeder
resources/views/     Blade pages
resources/js/        Vue components and browser interactions
resources/css/       Shared application styles
routes/               Web and API routes
tests/                PHPUnit tests
```

This repository is intentionally compact and approachable: enough functionality to explore a real Laravel/Vue workflow without hiding it behind a large application structure.
