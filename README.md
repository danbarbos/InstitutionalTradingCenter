# InstitutionalTradingCenter



Table of Contents
Project Overview

Key Features

Screenshots

Technologies Used

Architecture & File Structure

Installation

Configuration

Usage Guide

Admin Features

Troubleshooting

Contributing

Security Notes

Author

License

References & Credits

Last Updated

Project Overview
The Institutional Trading Center project is a robust, web-based application for managing financial positions and trading activities in an institutional investment context. It is designed with a focus on secure authentication, real-time data integration, efficient tracking of positions and trades, and high usability for both individual investors and financial administrators. This application underpins practical database, session, and API integration principles, making it a solid academic and practical resource for students and professionals alike.​

Key Features
Secure Authentication: Access is protected by login; sessions are validated and unauthorized users are redirected.

Personalized Dashboard: Interactive welcome messages and user-friendly navigation.

TradingView Integration: Embedded widgets for market heatmaps, live charts, latest news, and economic events.

Portfolio, Trade, and Institution Tracking: View/manage positions, portfolios, counterparties, and trade history easily.

Admin Dashboard: CRUD management of system portfolios, institutions, and counterparties with strict role enforcement.

Responsive & Accessible UI: Mobile-friendly navigation, ARIA labels, keyboard accessibility, and smooth section scroll snap.

Session Security: Periodic validation with automatic logout on session expiry.

Modern Visuals: SVG icons, smooth scrolling, and visually appealing layout.

Screenshots
Include screenshots here to showcase dashboard views, TradingView integration, trading/portfolio screens, and admin panels to give users a clear visual overview.
For example:
![Login Page](images/login.jpg

Technologies Used
Backend: PHP 7.x+, Microsoft SQL Server

Frontend: HTML5, CSS3, JavaScript ES6+

Authentication: Custom session management (PHP)

Database: Relational, with robust schema for positions, trades, institutions, and users

Market Data: TradingView Widgets embedded for real-time financial information

Security: Input sanitization (htmlspecialchars), session/timeouts, role-based access

Architecture & File Structure
login.php: User authentication

dashboard.php: Main dashboard logic

dbconfig.php: Database connection settings

useractions/: User trade additions, close positions, get price

admin/: Admin-only CRUD panels for portfolios, institutions, and counterparties

views/: UI components for portfolios, institution, trade history, etc.

css/: Styling (e.g., style.css)

images/: Visual assets for branding/UI

logout.php: Safely end session and redirect

Refer to the included architecture diagram or folder map for a detailed structure.

Installation
Prerequisites
PHP 7.x or later

Microsoft SQL Server (local/remote)

Web server (Apache/IIS recommended)

Steps
Clone the repository

text
git clone https://github.com/your-username/itc-financial-positions.git
cd itc-financial-positions
Set up the SQL Server Database

Create database and tables per the included schema (/docs/db-schema.sql)

Ensure credentials for a database admin user.

Configure Database Connection

Edit dbconfig.php

Set server name, username, password, and database name.

Deploy to Web Server

Copy all files to your web server's root or appropriate directory.

Start Application

Access login.php in your browser to begin.

Tip: For screenshots, add images to the images/ folder and reference them with descriptive alt texts.​

Configuration
.env / config settings: Not used; all configurations are in dbconfig.php.

Role setup: At least one admin user needs to be present in the database (manually create in initial SQL or by first login).

Usage Guide
For Users
Visit the login page.

Enter username and password.

Browse dashboard to view portfolios, open positions, and current market data.

Use the Trade menu to add new trades or manage open positions.

Logout securely when finished.

For Admins
Log in with admin account.

Access the Admin menu for management tools.

Add/edit/delete portfolios, institutions, and counterparties.

Monitor system usage and manage user data integrity.

Admin Features
Portfolios Management: Create, edit, remove any user portfolio.

Institutions & Counterparties: CRUD operations for all entities in the system.

User Oversight: Monitor and manage user activity logs for compliance and transparency.

Admin-only routes are protected and inaccessible without elevated privileges.​

Troubleshooting
Cannot Connect to Database:
Check settings in dbconfig.php, SQL Server availability, and credentials permissions.

Login Issues:
Ensure the username exists in the database and the password is correct (passwords may not be encrypted in this demo setup; add encryption for production).

Widget Display Problems:
Ensure third-party widget script URLs are enabled and networking policies (e.g., CORS) permit access.

Session Timeouts:
Sessions expire after inactivity; log in again if required.

For additional issues, check the server error logs or reach out using the issues page on GitHub.

Contributing
Contributions are welcome!
To propose a feature or bugfix:

Fork the repository

Create a new branch (feature/your-feature)

Commit your changes

Open a pull request detailing your changes

Pull requests should be linked to an open Issue where possible, and follow the code style guidelines included in /docs/CONTRIBUTING.md (if provided).

Security Notes
Ensure passwords are encrypted for production deployments.

Regularly review user and admin permissions.

Sanitize all user inputs and review session management logic for vulnerabilities.

Author
Barbos Dan-Alexandru
Databases Course Project
Technical University of Cluj-Napoca (TUCN)
Contact info optional - add email/GitHub/LinkedIn as you see fit.

License
Indicate your license, e.g., MIT included in this repository.

References & Credits
PHP Documentation: https://www.php.net/manual/en

Microsoft SQL Server Docs: https://docs.microsoft.com/en-us/sql/sql-server

TradingView Widget API: https://www.tradingview.com/widget

Stack Overflow for PHP + SQL integration support

Icon and image credits in the images/ directory and project documentation















