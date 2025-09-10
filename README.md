# Email Management System

A simple and elegant Laravel application for managing email addresses with full CRUD operations and soft delete functionality.

## Features

-   ✅ **Add Email Addresses**: Create and store email addresses with validation
-   ✅ **View Email List**: Browse all stored emails with pagination (10 emails per page)
-   ✅ **View Individual Email**: See details of a specific email
-   ✅ **Delete Emails**: Soft delete functionality to remove emails
-   ✅ **Email Validation**: Ensures unique email addresses (excluding soft-deleted ones)
-   ✅ **Pagination**: Efficient browsing through large email lists

## Technology Stack

-   **Backend**: Laravel 12.x
-   **Frontend**: Blade templates with custom CSS
-   **Database**: PostgreSQL
-   **PHP Version**: 8.2+

## Installation

### Prerequisites

-   PHP 8.2 or higher
-   Composer
-   Node.js and NPM (for frontend assets)

### Setup Instructions

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd Emails_Management
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Install Node.js dependencies**

    ```bash
    npm install
    ```

4. **Environment setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Database setup**

    ```bash
    # Configure MySQL/PostgreSQL in .env file
    ```

6. **Run migrations**

    ```bash
    php artisan migrate
    ```

7. **Build frontend assets**

    ```bash
    npm run build
    # or for development
    npm run dev
    ```

8. **Start the development server**

    ```bash
    php artisan serve
    ```

    The application will be available at `http://localhost:8000`

## Usage

### Available Routes

| Method | URI            | Action  | Description                 |
| ------ | -------------- | ------- | --------------------------- |
| GET    | `/`            | create  | Show email creation form    |
| POST   | `/store`       | store   | Store new email address     |
| GET    | `/emails`      | index   | List all emails (paginated) |
| GET    | `/emails/{id}` | show    | View specific email details |
| DELETE | `/emails/{id}` | destroy | Soft delete an email        |


## Database Schema

### Emails Table

```sql
- id (Primary Key)
- email (String)
- deleted_at (Timestamp, nullable) - for soft deletes
- created_at (Timestamp)
- updated_at (Timestamp)
```

