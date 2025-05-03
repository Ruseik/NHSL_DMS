# National Hospital of Sri Lanka - Diet Management System

A comprehensive web application for managing and analyzing patient diet details at the National Hospital of Sri Lanka. This system streamlines the process of diet management, ensuring efficient tracking and analysis of dietary requirements across different hospital units.

## System Overview

### Architecture
- Built on the MVC (Model-View-Controller) architecture pattern
- Implements separation of concerns for better maintainability
- Modular design for easy feature extensions

### Technology Stack
- **Backend**: PHP 7.4+ with Apache2 web server
- **Database**: MySQL 5.7+ with phpMyAdmin interface
- **Frontend**: HTML5, CSS3, JavaScript
- **Security**: PDO, prepared statements, input validation

## Features

### Core Functionality
- **Diet Management**
  - Cart-like interface for diet item selection
  - Quantity management for each diet item
  - Real-time updates and calculations

### User Management
- Role-based access control system
- Secure authentication and authorization
- Session management and security

### Analytics & Reporting
- Comprehensive statistical reports
- Data visualization dashboard
- Export functionality for reports

### System Administration
- Ward/Unit management interface
- Diet item registry maintenance
- User account administration

## User Roles & Permissions

### Diet Clerk
- System login access
- Ward/Unit selection capability
- Diet item entry and management
- Basic report viewing

### Chief Diet Clerk
- All Diet Clerk privileges
- Access to statistical reports
- Analytics dashboard viewing
- User account management

### Programmer/Administrator
- Complete system access
- Registry management
- System configuration
- Security settings control

## Installation Guide

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache2 web server
- PDO PHP Extension
- MySQL PHP Extension
- Composer (for dependency management)

### Step-by-Step Installation
1. **Clone Repository**
   ```bash
   git clone [repository-url]
   cd NHSL_DMS
   ```

2. **Database Setup**
   - Create a new MySQL database
   - Import schema: `mysql -u [username] -p [database_name] < sql/create_tables.sql`
   - Configure connection in `config/database.php`

3. **Application Configuration**
   - Copy `.env.example` to `.env`
   - Update environment variables
   - Set appropriate file permissions

4. **Web Server Configuration**
   - Configure Apache virtual host
   - Enable required PHP extensions
   - Set document root to `/public`

## Security Implementation

### Database Security
- PDO with prepared statements
- Input validation and sanitization
- SQL injection prevention

### Authentication & Authorization
- Secure session management
- Role-based access control
- Password hashing with strong algorithms

### Web Security
- XSS prevention
- CSRF protection
- Secure headers configuration

## Project Structure
```
/project-root
├── /config           # Configuration files
│   ├── database.php  # Database configuration
│   └── app.php       # Application settings
├── /public           # Web root directory
│   ├── index.php     # Entry point
│   └── .htaccess     # Apache configuration
├── /src              # Application source code
│   ├── /Controllers  # MVC Controllers
│   ├── /Models       # MVC Models
│   └── /Views        # MVC Views
├── /sql              # Database scripts
└── /storage          # Application storage
```

## Development Guidelines

### Coding Standards
- Follow PSR-4 autoloading standards
- Maintain consistent code formatting
- Document all classes and methods

### Version Control
- Use feature branches for development
- Follow semantic versioning
- Maintain clean commit history

## Production Deployment

### Server Requirements
- Dedicated or VPS hosting
- SSL certificate
- Regular backup system

### Performance Optimization
- Enable PHP OPcache
- Configure MySQL query cache
- Implement application-level caching

### Monitoring
- Set up error logging
- Monitor system resources
- Track user activities

## Troubleshooting

### Common Issues
1. Database connection errors
   - Verify credentials in config
   - Check MySQL service status

2. Permission problems
   - Verify file/directory permissions
   - Check Apache user rights

3. Session handling issues
   - Validate PHP session configuration
   - Check session storage path

## Support & Maintenance

### Technical Support
For technical issues or bug reports:
- Contact system administrator
- Submit detailed bug reports
- Follow support procedures

### System Updates
- Regular security patches
- Feature updates
- Database maintenance

### Backup Procedures
- Daily database backups
- Regular file system backups
- Backup verification process


![CodeRabbit Pull Request Reviews](https://img.shields.io/coderabbit/prs/github/Ruseik/NHSL_DMS?utm_source=oss&utm_medium=github&utm_campaign=Ruseik%2FNHSL_DMS&labelColor=171717&color=FF570A&link=https%3A%2F%2Fcoderabbit.ai&label=CodeRabbit+Reviews)
