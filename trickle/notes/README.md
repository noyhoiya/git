# Cash Center - Laravel Financial Management System

## Project Overview
A comprehensive enterprise-grade cash center application built with Laravel for managing vault operations, cash requests, and financial workflows in professional banking and financial institutions.

## Features
- **User Management**: Role-based authentication with 5 distinct user types
- **Vault Operations**: Multi-vault cash management system (MAIN/SUB vaults)
- **Cash Request Workflow**: Teller cash withdrawal requests with approval process
- **Vault Movements**: Controlled cash transfers between vaults with audit trails
- **Financial Dashboard**: Real-time statistics and operational metrics
- **API Integration**: RESTful APIs for mobile and external system integration

## System Requirements & Installation

### Prerequisites
- **PHP 8.1+** with extensions: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML
- **Composer** (latest version)
- **Database**: MySQL 5.7+ / PostgreSQL 12+ / SQLite 3.8.8+
- **Web Server**: Apache with mod_rewrite or Nginx

### Quick Setup Guide
1. **Download & Install Dependencies**
   ```bash
   git clone <repository>
   cd cash-center
   composer install
   ```

2. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   # Configure database in .env file
   php artisan migrate --seed
   ```

4. **Start Server**
   ```bash
   php artisan serve
   # Access: http://localhost:8000
   # Login: admin / password
   ```

### Troubleshooting Common Issues
- **PDO Error**: Install `php-mysql` extension
- **Permission Error**: Set `755` permissions for `storage/` and `bootstrap/cache/`
- **Key Error**: Run `php artisan key:generate`
- **Database Error**: Verify credentials in `.env` file

## Architecture
- **Backend**: Laravel 10 with PHP 8.1+ framework
- **Database**: MySQL with comprehensive relational structure
- **Authentication**: Laravel Sanctum for web and API token management
- **Frontend**: Blade templates with TailwindCSS styling
- **API**: RESTful endpoints for mobile/external access

## Key Models
- `User`: Role-based user management with permissions
- `Vault`: Cash storage locations with balance tracking
- `CashRequest`: Withdrawal requests with approval workflow
- `VaultMovement`: Inter-vault cash transfers with denominations
- `Role`: Permission-based access control system
- `Purpose`: Transaction categorization and reporting

## Database Structure
- **8 Core Tables**: Users, Roles, Vaults, Cash Requests, Movements, Purposes, Denominations
- **Foreign Key Relationships**: Comprehensive data integrity
- **Audit Trail**: Complete transaction history with timestamps
- **Balance Tracking**: Real-time vault balance management

## User Roles & Access Control
- **MAIN_VAULT**: Full operational control and approvals
- **TELLER**: Cash request creation and transaction viewing  
- **ADMIN_VAULT**: Administrative vault operations
- **AUDITOR**: Read-only access for compliance and review
- **ADMIN**: System administration and user management

## Workflow Processes
- **Cash Request Process**: Teller → Main Vault approval → Movement creation → Cash handover
- **Vault Movement Process**: Initiation → Balance validation → Physical transfer → Balance updates
- **User Setup Process**: Admin creation → Role assignment → Account activation

## Security Features
- **Password Hashing**: Laravel's built-in bcrypt security
- **Role Middleware**: Route-level permission enforcement
- **CSRF Protection**: Form security against cross-site attacks
- **API Authentication**: Sanctum token-based API access
- **Input Validation**: Comprehensive request validation rules

## API Endpoints
- Authentication: `/api/auth/*`
- Cash Operations: `/api/cash-requests/*`, `/api/vault-movements/*`
- Dashboard Data: `/api/dashboard/*`
- Vault Status: `/api/vaults/*`

## Production Deployment
- Configure `.env` for production environment
- Run `composer install --optimize-autoloader --no-dev`
- Execute `php artisan config:cache route:cache view:cache`
- Set proper file permissions and web server configuration
- Configure SSL certificates for HTTPS

## Development & Maintenance
- Follow Laravel best practices for code organization
- Implement proper error handling and logging
- Regular database backups and security updates
- Monitor system performance and user activity

## Future Enhancements
- Advanced reporting and analytics
- Multi-currency support
- Mobile application development
- Automated backup systems
- Integration with banking APIs
- Advanced audit and compliance features

---
*Last updated: January 2025*
