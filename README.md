# Driving Experience Manager

A comprehensive web application for managing supervised driving experiences, built with PHP and MySQL.

## Features

- **Add Driving Experiences**: Mobile-responsive form to record driving sessions with date, time, kilometers, weather conditions, road types, traffic conditions, and notes
- **Summary Table**: View all experiences with filtering options (by date range, weather conditions) and total kilometers calculation
- **Statistics Dashboard**: Visual analytics with charts showing distribution of weather conditions, road types, traffic conditions, and monthly kilometers
- **Database Design**: Normalized database with many-to-many relationships for flexible data management

## Technical Stack

- **Backend**: PHP (PDO for database operations)
- **Database**: MySQL with proper relationships and indexes
- **Frontend**: HTML5, Tailwind CSS (CDN), Chart.js for visualizations
- **Features**: PHP Sessions, Mobile-responsive design, Table sorting/filtering

## Database Structure

The application uses a normalized database design with:

- `driving_experiences`: Main table storing date, time, kilometers, and notes
- `weather_conditions`: Weather options (Sunny, Cloudy, Rainy, etc.)
- `road_types`: Road type options (Highway, City Street, etc.)
- `traffic_conditions`: Traffic condition options (Light, Moderate, Heavy, etc.)
- Junction tables for many-to-many relationships:
  - `experience_weather`
  - `experience_road_types`
  - `experience_traffic`

## Installation

1. Configure your database connection in `.env` file:
```
DB_HOST=localhost
DB_USER=your_username
DB_PASSWORD=your_password
DB_NAME=driving_experience_db
DB_PORT=3306
```

2. Initialize the database by running:
```bash
php database/init.php?init=1
```

Or manually import `database/init.sql` using phpMyAdmin.

3. Ensure your web server has write permissions and PHP sessions are enabled.

## Usage

- **Dashboard**: Overview with total kilometers, experience count, and recent entries
- **Add Experience**: Fill out the form to record a new driving experience
- **Summary**: View all experiences with filtering and sorting capabilities
- **Statistics**: Visual charts and detailed statistics about driving conditions

## File Structure

```
/
├── index.php                 # Main entry point with routing
├── config.php                # Database configuration
├── database.php              # Database connection helper
├── database/
│   ├── init.sql             # Database schema
│   └── init.php             # Database initialization script
├── src/
│   ├── models/
│   │   ├── Experience.php   # Experience model
│   │   └── Variable.php     # Variable model
│   ├── controllers/
│   │   └── ExperienceController.php
│   ├── views/
│   │   ├── header.php
│   │   ├── footer.php
│   │   ├── dashboard.php
│   │   ├── form.php
│   │   ├── summary.php
│   │   └── statistics.php
│   ├── includes/
│   │   ├── session.php
│   │   └── flash.php
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── main.js
└── README.md
```

## Technical Highlights

- Clean MVC-like architecture with separation of concerns
- PDO prepared statements for secure database operations
- Responsive design using Tailwind CSS with mobile-first approach
- Interactive charts using Chart.js library
- Client-side form validation and table sorting
- PHP sessions for flash messages and state management
- W3C compliant HTML5 with semantic elements

