# Cash Center - Laravel Financial Management System

A comprehensive cash center application built with Laravel for managing financial transactions, tracking cash flow, and monitoring vault operations in professional environments.

## Features

### Core Functionality
- **User Management**: Role-based authentication with 5 user types (MAIN_VAULT, TELLER, ADMIN_VAULT, AUDITOR, ADMIN)
- **Vault Operations**: Multi-vault cash management with main and sub-vault support
- **Cash Requests**: Teller cash withdrawal requests with approval workflow
- **Vault Movements**: Cash transfers between vaults with denomination tracking
- **Financial Reporting**: Real-time dashboard with cash flow analytics

### Technical Features
- **Database**: MySQL with comprehensive relational structure
- **Authentication**: Laravel Sanctum for web and API authentication
- **API Support**: RESTful APIs for mobile/external integration
- **Security**: Role-based access control and secure password handling
- **Responsive Design**: TailwindCSS with professional financial UI

## System Requirements

### Prerequisites
- **PHP**: 8.1 or higher with extensions:
  - BCMath PHP Extension
  - Ctype PHP Extension
  - cURL PHP Extension
  - DOM PHP Extension
  - Fileinfo PHP Extension
  - JSON PHP Extension
  - Mbstring PHP Extension
  - OpenSSL PHP Extension
  - PCRE PHP Extension
  - PDO PHP Extension
  - Tokenizer PHP Extension
  - XML PHP Extension
- **Composer**: Latest version
- **Database**: MySQL 5.7+ or PostgreSQL 12+ or SQLite 3.8.8+
- **Web Server**: Apache with mod_rewrite or Nginx
- **Node.js & NPM**: For frontend asset compilation (optional)

## Installation Guide

### Step 1: Download Project
```bash
# Clone the repository
git clone <your-repository-url>
cd cash-center

# Or download ZIP and extract
```

### Step 2: Install PHP Dependencies
```bash
# Install Composer dependencies
composer install

# If composer is not installed, download it first:
# curl -sS https://getcomposer.org/installer | php
# php composer.phar install
```

### Step 3: Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Set application name (optional)
# Edit .env file and update APP_NAME="Your Cash Center Name"
```

### Step 4: Database Configuration
```bash
# Option A: MySQL Setup
# 1. Create database in MySQL:
mysql -u root -p
CREATE DATABASE cash_center;
EXIT;

# 2. Configure database in .env file:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cash_center
DB_USERNAME=root
DB_PASSWORD=your_mysql_password

# Option B: SQLite Setup (Simpler for development)
# 1. Configure database in .env file:
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
# Comment out other DB_ variables

# 2. Create SQLite file:
touch database/database.sqlite
```

### Step 5: Database Migration and Seeding
```bash
# Run database migrations
php artisan migrate

# Seed database with initial data
php artisan db:seed

# Or run both together:
php artisan migrate --seed
```

### Step 6: Storage and Cache Setup
```bash
# Create storage link for file uploads
php artisan storage:link

# Clear and cache configuration (optional but recommended)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 7: Start Development Server
```bash
# Start Laravel development server
php artisan serve

# Server will start at: http://localhost:8000
```

## Default Login Credentials

After successful installation, use these credentials to log in:

- **Username**: `admin`
- **Password**: `password`
- **Role**: System Administrator

## Post-Installation Verification

### 1. Access the Application
- Open browser and go to `http://localhost:8000`
- Login with default credentials
- You should see the dashboard with initial data

### 2. Check System Status
- Navigate to different sections (Cash Requests, Vault Movements, etc.)
- Verify that all pages load without errors
- Check that icons and fonts display properly

### 3. Test Basic Functionality
- Try creating a new cash request
- Test vault movement creation
- Verify user role permissions work correctly

## Troubleshooting

### Common Issues and Solutions

**Issue: "Class 'PDO' not found"**
```bash
# Install PHP PDO extension
sudo apt-get install php-mysql  # Ubuntu/Debian
# or
sudo yum install php-pdo php-mysql  # CentOS/RHEL
```

**Issue: "Permission denied" errors**
```bash
# Set proper permissions for Laravel directories
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

**Issue: "Key not found" error**
```bash
# Generate new application key
php artisan key:generate
```

**Issue: Database connection errors**
```bash
# Check database credentials in .env file
# Test database connection:
php artisan migrate:status
```

**Issue: "Composer not found"**
```bash
# Install Composer globally
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

## Production Deployment

### 1. Server Requirements
- PHP 8.1+ with required extensions
- MySQL/PostgreSQL database
- Web server (Apache/Nginx) with SSL
- Composer installed

### 2. Deployment Steps
```bash
# Upload project files
# Configure .env for production
APP_ENV=production
APP_DEBUG=false

# Install dependencies
composer install --optimize-autoloader --no-dev

# Run optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chmod -R 755 storage bootstrap/cache
```

### 3. Web Server Configuration

**Apache (.htaccess already included)**
```apache
# Point document root to /public directory
DocumentRoot "/path/to/cash-center/public"
```

**Nginx**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/cash-center/public;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
    }
}
```

## Additional Configuration

### Email Setup (Optional)
Configure email settings in `.env` for notifications:
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

### Backup Strategy
```bash
# Database backup
mysqldump -u username -p cash_center > backup.sql

# Automated backup (add to crontab)
0 2 * * * mysqldump -u username -p cash_center > /backups/cash_center_$(date +\%Y\%m\%d).sql
```

## Database Structure

### Core Tables
- **roles**: User permission levels
- **users**: System users with role assignments
- **vaults**: Cash storage locations (MAIN/SUB types)
- **purposes**: Transaction categorization
- **cash_requests**: Withdrawal requests from tellers
- **vault_movements**: Cash transfers between vaults
- **denomination tables**: Bill/coin breakdown tracking

### Default Data
- Admin user: `admin` / `password`
- 5 user roles with different permissions
- Main vault with ₱100,000 initial balance
- Standard transaction purposes

## User Roles & Permissions

| Role | Permissions |
|------|-------------|
| **MAIN_VAULT** | Full vault operations, approve requests, manage movements |
| **TELLER** | Create cash requests, view own transactions |
| **ADMIN_VAULT** | Administrative vault operations |
| **AUDITOR** | Read-only access for review and reporting |
| **ADMIN** | System administration, user management |

## API Endpoints

### Authentication
- `POST /api/auth/login` - User login
- `POST /api/auth/logout` - User logout

### Cash Operations
- `GET /api/cash-requests` - List cash requests
- `POST /api/cash-requests` - Create new request
- `POST /api/cash-requests/{id}/approve` - Approve request
- `GET /api/vault-movements` - List movements
- `POST /api/vault-movements/{id}/post` - Post movement

### Dashboard
- `GET /api/dashboard/stats` - System statistics
- `GET /api/vaults/{id}/balance` - Vault balance

## Workflow Processes

### Cash Request Process
1. Teller creates cash request with amount and purpose
2. Main vault operator reviews and approves/rejects
3. System creates vault movement for approved requests
4. Physical cash handover with balance updates

### Vault Movement Process
1. Operator initiates movement (withdrawal/handover)
2. System validates source vault balance
3. Movement posted with denomination tracking
4. Automatic balance updates for both vaults

## Security Features

- Password hashing with Laravel's built-in security
- Role-based route protection middleware
- CSRF protection on all forms
- API token authentication with Sanctum
- Input validation and sanitization

## Development

### File Structure
```
app/
├── Http/Controllers/     # Request handling
├── Models/              # Database models
└── Providers/           # Service providers

database/
├── migrations/          # Database schema
└── seeders/            # Initial data

resources/views/         # Blade templates
routes/                 # Web and API routes
```

### Extending the System
- Add new user roles in `Role` model
- Create additional transaction purposes
- Implement new vault types
- Add custom reporting features

## Deployment

### Production Setup
1. Configure production database
2. Set `APP_ENV=production` in .env
3. Run `php artisan config:cache`
4. Set up web server (Apache/Nginx)
5. Configure SSL certificates

### Monitoring
- Database backup strategies
- Cash flow audit trails
- User activity logging
- Balance reconciliation reports

---

© 2025 Cash Center. Professional Financial Management System.