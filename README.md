# Chronos Logger
A simple logging service built with Laravel.

## Installation
To get started with this project, clone the repository and install the dependencies:

```bash
git clone https://github.com/RakInteractive/Chronos.git
cd Chronos
composer install
npm install
npm run build
```

### Environment Configuration
Copy the `.env.example` file to `.env` and update the environment variables as needed:
```bash
cp .env.example .env
```

### Application Key
Generate the application key using the Artisan command:
```bash
php artisan key:generate
```

### Database Migration
Run the database migrations to set up the database schema:
```bash
php artisan migrate
```

Create a new user:
```bash
php artisan user:create
```

# Documentation
For detailed documentation, please visit the [Wiki section](https://github.com/RakInteractive/Chronos/wiki)

## License

The Laravel framework is open-sourced software licensed under the [AGPL-3.0 License](https://www.gnu.org/licenses/agpl-3.0.txt).  
Please see the [LICENSE](LICENSE) file for details.

## UI
Yeah, the UI looks pretty bad right now, we're working on it.
