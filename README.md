# Airo Laravel Project

## Overview

This is a Laravel-based API project that provides user authentication and quotation management functionality. The project uses Laravel Sail for local development with Docker, making it easy to get started without installing PHP or other dependencies directly on your machine.

### Main Features

- **User Registration & Login**: Secure JWT-based authentication for registering and logging in users.
- **Profile Management**: Authenticated users can view their profile information.
- **Quotation Management**: Authenticated users can:
  - List their quotations
  - Create new quotations (with age, currency, and date range)
  - View details of a specific quotation

## Installation

### Prerequisites

- [Docker](https://www.docker.com/get-started) installed on your machine.
- [Composer](https://getcomposer.org/) (for installing Sail, if not already present).

### Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Juzepe/airo
   cd airo
   ```

2. **Install dependencies using Composer:**
   ```bash
   composer install
   ```

3. **Copy the example environment file and set your environment variables:**
   ```bash
   cp .env.example .env
   ```

4. **Install Laravel Sail (if not already installed):**
   ```bash
   composer require laravel/sail --dev
   ```

5. **Start the Sail environment:**
   ```bash
   ./vendor/bin/sail up -d
   ```

6. **Run database migrations and seeders:**
   ```bash
   ./vendor/bin/sail artisan migrate --seed
   ```

7. **Generate JWT secret:**
   ```bash
   ./vendor/bin/sail artisan jwt:secret
   ```

8. **Access the application:**
   - The API will be available at `http://localhost:28080` (or the port you configured in `.env` `APP_PORT`).

## Usage

- Use the provided API endpoints for registration, login, profile, and quotation management.
- All quotation endpoints require authentication via JWT.

## API Endpoints

- `POST /api/register` — Register a new user
- `POST /api/login` — Login and receive a JWT token
- `GET /api/profile` — Get authenticated user profile (requires JWT)
- `POST /api/logout` — Logout (requires JWT)
- `GET /api/quotations` — List all quotations for the authenticated user
- `POST /api/quotations` — Create a new quotation
- `GET /api/quotations/{quotation}` — View a specific quotation
