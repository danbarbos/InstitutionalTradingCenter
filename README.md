# InstitutionalTradingCenter




 


Institutional Trading Center
FINANCIAL POSITIONS MANAGEMENT WEB APPLICATION










Barbos Dan-Alexandru| 30322 | Databases | 31.05.2025 


1. Introduction
Purpose of the Project
This project aims to develop a web-based application for managing financial positions, including functionalities such as user authentication, position tracking, and integration of real-time market data via TradingView widgets. The application demonstrates practical use of database concepts, session management, and third-party API integration, fulfilling the requirements of the Databases course at TUCN.

Scope
The application targets users who want to monitor and manage their financial investments efficiently, providing a user-friendly dashboard with interactive market data visualizations.
2. Main Features
2.1 User Features
•	Secure Authentication & Session Management
Users must log in to access the dashboard. Sessions are managed using PHP, and unauthorized access redirects to the login page.
 
•	Personalized Welcome Pop-up
Upon login, users are greeted with a personalized welcome message, which can be dismissed with a smooth animation for a better user experience. 
 
•	User Navigation (Views & Trade Menus)
•	Views menu:
•	Portfolios: View all user portfolios.
•	Institutions: View institutions associated with the user.
•	Counterparties: View counterparties involved in trades.
•	Trade History: View the user's trade history. 
 

•	Trade menu:
•	Add Trade: Interface for adding a new trade.
•	Positions: View and manage open positions (with options to close positions).

 



•	Interactive Dashboard with TradingView Widgets
•	Market Heatmap: Visualizes market sectors and performance.

 
•	Symbol Overview: Displays charts for selected stocks (e.g., Apple, Google, Microsoft).
 
•	Latest News: Shows real-time financial news.
 
•	Economic Calendar: Displays upcoming economic events 
•	Each widget is placed in its own scrollable section, with smooth snap scrolling for intuitive navigation.
•	Logout Functionality
Users can securely log out, ending their session and returning to the login page.
 
________________________________________
2.2 Admin Features
•	Admin-Only Dashboard Menu
When logged in as an admin (role detected via session), the navigation bar displays an "Admin" menu instead of the user menus.

•	Admin Management Tools
•	Manage Portfolios: Access to CRUD operations for all portfolios in the system.
•	Manage Institutions: CRUD interface for managing institutions.
•	Manage Counterparties: CRUD interface for counterparties.
(All admin routes are separated and accessible only with the admin role.) 

•	System Oversight
Admins can oversee all user activities, manage data integrity, and ensure system security.
________________________________________
2.3 Responsive & Accessible Design
•	Responsive Navigation
The navigation menu adapts for mobile devices, with dropdown toggles for submenu access.
•	Accessibility
ARIA labels and roles are used for better accessibility, especially in navigation and pop-up components.
________________________________________
2.4 Enhanced User Experience
•	Smooth Scroll Snap
JavaScript and CSS are used to ensure that scrolling between dashboard sections is smooth and automatically "snaps" to the nearest widget section.
•	Modern UI Elements
SVG icons, styled buttons, and visually appealing widget containers contribute to a modern, user-friendly interface.
________________________________________
2.5 Security
•	Session Validation
Every page checks for an active session; if none is found, the user is redirected to the login page.
•	Role-Based Access
Features and navigation options are dynamically rendered based on the user's role (admin or regular user).

3. Application Structure

3.1 File Structure
.
├── itc/
│   ├── admin/
│   │   ├── crud_counterparties.php
│   │   ├── crud_institutions.php
│   │   └── crud_portfolios.php
│   ├── css/
│   │   └── style.css
│   ├── images/
│   │   ├── background.gif
│   │   ├── login.jpg
│   │   └── logout-icon.svg
│   └── user/
│       ├── actions/
│       │   ├── cache/
│       │   ├── add_trade.php
│       │   ├── close_position.php
│       │   ├── get_price.php
│       │   └── positions
│       └── views/
│           ├── portfolios.php
│           ├── vcounterparties.php
│           ├── vinstitutions.php
│           └── vtradehistory.php
├── dashboard.php
├── db_config.php
├── login.php
└── logout.php________________________________________
3.2 Database Design

 

________________________________________
3.3 Application Flow
1.	Login
•	User visits login.php → Enters credentials → Session starts. 
 

2.	Dashboard
•	After login, redirected to dashboard.php:
•	Admins see Admin Menu (access to crud_*.php scripts).
•	Regular users see User Menu (access to views/ and actions/).

 



 
3.	User Actions
•	Add Trade: add_trade.php inserts data into positions table.
 

•	Close Position: close_position.php updates status in positions.
•	Fetch Prices: get_price.php retrieves real-time data (cached in cache/).
4.	Admin Actions
•	Manage entities via CRUD scripts (e.g., crud_counterparties.php updates the counterparties table).
 

5.	Logout
•	logout.php destroys the session and redirects to login.php.
________________________________________
3.4 Code Snippets
Database Connection (db_config.php)
<?php
// db_config.php
$serverName = "localhost";
$connectionOptions = array(
    "Database" => "Institutional Trading Center",
    "Uid" => "admin", // Using admin credentials for database connection
    "PWD" => "parola1"
);

// Establish the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}
?>

Role-based navigation (dashboard.php)
<?php if ($role === 'admin'): ?>
                <li>
                    <a href="#" tabindex="0">Admin</a>
                    <ul class="submenu" aria-label="Admin menu">
                        <li><a href="../admin/crud_portfolios.php">Manage Portfolios</a></li>
                        <li><a href="../admin/crud_institutions.php">Manage Institutions</a></li>
                        <li><a href="../admin/crud_counterparties.php">Manage Counterparties</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li>
                    <a href="#" tabindex="0">Views</a>
                    <ul class="submenu" aria-label="Views menu">
                        <li><a href="../user/views/portfolios.php">Portfolios</a></li>
                        <li><a href="../user/views/vinstitutions.php">Institutions</a></li>
                        <li><a href="../user/views/vcounterparties.php">Counterparties</a></li>
                        <li><a href="../user/views/vtradehistory.php">Trade History</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" tabindex="0">Trade</a>
                    <ul class="submenu" aria-label="Trade menu">
                        <li><a href="../user/actions/add_trade.php">Add Trade</a></li>
                        <li><a href="../user/actions/positions.php">Positions</a></li>
                    </ul>
                </li>
            <?php endif; ?>

3.5 Technologies Used
•	Backend: PHP, MS SQL Server
•	Frontend: HTML5, CSS3, JavaScript
•	Security: Input sanitization (htmlspecialchars)
•	Third-Party: TradingView widgets for market data


4. Bibliography
Online Documentation
1.	PHP Documentation. (n.d.).
https://www.php.net/manual/en/
— Used for PHP session management, database connection, and security best practices.
2.	Microsoft SQL Server Documentation. (n.d.).
https://docs.microsoft.com/en-us/sql/sql-server/
— Used for SQL Server syntax, data types, and stored procedures.
Code and Widgets
3.	TradingView Widget Documentation. (n.d.).
https://www.tradingview.com/widget/
— Used for embedding and configuring TradingView widgets in the dashboard.
4.	Stack Overflow. (n.d.).
https://stackoverflow.com/questions/
— Used for troubleshooting PHP and SQL Server integration issues.
Images and Icons
5.	“logout-icon.svg” from https://www.svgrepo.com/
— Used as the logout icon in the navigation bar.
6.	“login.jpg” https://4kwallpapers.com/technology/forex-day-trading-13825.html
— Used as the background image for the login page.
7.	“background.gif” https://pixabay.com/videos/investment-finance-business-company-204292/
— Used as the background image for the dashboard.

























