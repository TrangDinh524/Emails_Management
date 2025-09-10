# Email Management System

A simple and elegant Laravel application for managing email addresses with full CRUD operations and soft delete functionality.

## Features

-   ✅ **Add Email Addresses**: Create and store email addresses with validation
-   ✅ **View Email List**: Browse all stored emails with pagination (5 emails per page)
-   ✅ **View Individual Email**: See details of a specific email
-   ✅ **Delete Emails**: Soft delete functionality to remove emails
-   ✅ **Email Validation**: Ensures unique email addresses (excluding soft-deleted ones)
-   ✅ **Responsive Design**: Clean and modern UI with CSS styling
-   ✅ **Pagination**: Efficient browsing through large email lists

## Technology Stack

-   **Backend**: Laravel 12.x
-   **Frontend**: Blade templates with custom CSS
-   **Database**: SQLite (default) / MySQL / PostgreSQL
-   **PHP Version**: 8.2+
-   **Features**: Soft Deletes, Form Validation, Pagination

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
    # For SQLite (default)
    touch database/database.sqlite

    # Or configure MySQL/PostgreSQL in .env file
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

### Key Features

#### Email Validation

-   Email format validation
-   Unique email constraint (excluding soft-deleted emails)
-   Allows re-adding previously deleted emails

#### Soft Delete

-   Emails are not permanently removed from database
-   Uses Laravel's SoftDeletes trait
-   Deleted emails can be restored if needed

#### Pagination

-   Displays 5 emails per page
-   Laravel's built-in pagination links
-   Efficient for large email collections

## Database Schema

### Emails Table

```sql
- id (Primary Key)
- email (String)
- deleted_at (Timestamp, nullable) - for soft deletes
- created_at (Timestamp)
- updated_at (Timestamp)
```

## Project Structure

```
Emails_Management/
├── app/
│   ├── Http/Controllers/
│   │   └── EmailController.php      # Main controller for email operations
│   └── Models/
│       └── Email.php                # Email model with soft deletes
├── database/
│   └── migrations/
│       └── 2025_09_09_091822_create_emails_table.php
├── resources/
│   ├── views/emails/
│   │   ├── create.blade.php         # Email creation form
│   │   ├── index.blade.php          # Email listing page
│   │   └── show.blade.php           # Email details page
│   └── css/
│       └── app.css                  # Custom styling
└── routes/
    └── web.php                      # Application routes
```

## Development

### Running Tests

```bash
php artisan test
```

### Code Style

```bash
./vendor/bin/pint
```

### Development Mode

```bash
composer run dev
```

This command runs:

-   Laravel development server
-   Queue worker
-   Log viewer (Pail)
-   Vite development server

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

If you encounter any issues or have questions, please open an issue in the repository.

---

**Built with ❤️ using Laravel**
