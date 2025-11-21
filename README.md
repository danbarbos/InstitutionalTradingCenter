# Institutional Trading Center  
_Financial Positions Management Web Application_

![GitHub last commit](https://img.shields.io/github/last-commit/danbarbos/AlgorithmicTradingSimulator)
![License](https://img.shields.io/badge/license-MIT-green)

<img width="1057" height="504" alt="image" src="https://github.com/user-attachments/assets/e129663a-0188-40e9-b648-beb16c31b83a" />

---

## Table of Contents

- [Project Overview](#project-overview)
- [Key Features](#key-features)
- [Technologies Used](#technologies-used)
- [Architecture & File Structure](#architecture--file-structure)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage Guide](#usage-guide)
- [Admin Features](#admin-features)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [Security Notes](#security-notes)
- [Author](#author)
- [License](#license)
- [References & Credits](#references--credits)
- [Last Updated](#last-updated)

---

## Project Overview

The Institutional Trading Center project is a robust, web-based application designed for managing financial positions and trading activities in an institutional investment setting. It supports secure authentication, real-time market data integration via TradingView widgets, and an intuitive dashboard to track portfolios, trades, and counterparties.

Developed as part of the Databases course at the Technical University of Cluj-Napoca (TUCN), this project demonstrates practical use of PHP, Microsoft SQL Server, session management, and third-party API integration.

---

## Key Features

- **Secure Authentication:** User login with session validation and access control.
- **Interactive Dashboard:** Personalized welcome messages, with TradingView widgets for market heatmaps, stock charts, latest financial news, and economic calendar.
- **Comprehensive Portfolio Management:** View and manage portfolios, institutions, counterparties, and trade history.
- **Trade Operations:** Add new trades, view and close open positions.
- **Role-Based Access Control:** Admin users have access to CRUD functionality for managing system data, while regular users access only their own data.
- **Responsive Design:** Mobile-friendly and accessible UI with ARIA labels and keyboard navigation support.
- **Smooth Scroll Snap:** JavaScript and CSS for intuitive navigation between dashboard widgets.
- **Security:** Input sanitization (`htmlspecialchars`) and session management to prevent unauthorized access.
- **Logout Functionality:** Secure session termination.

---

## Technologies Used

- **Backend:** PHP 7.x+, Microsoft SQL Server
- **Frontend:** HTML5, CSS3, JavaScript (ES6+)
- **Market Data:** TradingView Widgets integration for live financial data
- **Security:** Input sanitization, session validation, role-based routing

---

## Architecture & File Structure

- `login.php` — Authentication and session initialization
- `dashboard.php` — Main user/admin dashboard logic
- `dbconfig.php` — Database connection configuration
- `useractions/` — Handles user trades (addtrade.php, closeposition.php, getprice.php)
- `admin/` — Admin-only CRUD interfaces (crudportfolios.php, crudinstitutions.php, crudcounterparties.php)
- `views/` — UI components for portfolios, institutions, counterparties, trade history, etc.
- `css/style.css` — Styling rules
- `images/` — Backgrounds, icons, and UI assets
- `logout.php` — Session termination and redirection

---

## Installation

### Prerequisites
- PHP 7.x or later
- Microsoft SQL Server (local or remote)
- Web server (Apache or IIS recommended)

### Setup Instructions

1. Clone the repository:

`git clone https://github.com/your-username/institutional-trading-center.git`
`cd institutional-trading-center`


2. Setup Database:
- Create the database and tables using the provided SQL schema.
- Ensure credentials with sufficient permissions are available.

3. Configure the database connection in `dbconfig.php` with your server credentials:

`$serverName = "localhost";
$connectionOptions = [
"Database" => "Institutional Trading Center",
"Uid" => "admin",
"PWD" => "parola1"
];`


4. Deploy the files to your PHP-capable web server.

5. Open the application in your browser via the login page (`login.php`).

---

## Configuration

- Database credentials must be updated in `dbconfig.php` according to your setup.
- To enable admin features, assign the admin role in the users database table.

---

## Usage Guide

### For Users

- Log in with your credentials.
- Navigate through portfolios, institutions, and trades via the dashboard menus.
- Add new trades or close positions using the Trade interface.
- Monitor real-time market data and news via the embedded widgets.
- Log out securely when finished.

### For Admins

- Log in with an admin account.
- Access special admin menus for managing portfolios, institutions, and counterparties.
- Oversee all users’ activities and maintain system integrity.

---

## Admin Features

- Full CRUD operations for portfolios, institutions, and counterparties.
- Role-based routing to restrict sensitive actions exclusively to admin users.
- System oversight and data integrity maintenance.

---

## Troubleshooting

- Check database connectivity and credentials in `dbconfig.php` if the app cannot connect.
- Verify user credentials if login fails.
- Confirm network access to TradingView widget URLs for live data.
- Review PHP error logs for detailed error information.
- Sessions expire due to inactivity; re-login if the session ends.

---

## Contributing

Contributions are welcome! To contribute:

1. Fork the repository.
2. Create a feature branch: `git checkout -b feature-name`.
3. Commit your changes.
4. Push to your fork and open a Pull Request.

Please adhere to code and style guidelines.

---

## Security Notes

- Passwords should be secured and hashed in production.
- Input sanitization is provided but should be reviewed regularly.
- Sessions time out for security; always log out after use.
- Regularly update dependencies and review access roles.

---

## Author

**Barbos Dan-Alexandru**  
Technical University of Cluj-Napoca (TUCN)  
Databases Course Project - 2025

---

## License

This project is licensed under the __MIT License__. See the LICENSE file for details.

---

## References & Credits

- PHP Documentation - https://www.php.net/manual/en  
- Microsoft SQL Server Documentation - https://docs.microsoft.com/en-us/sql/sql-server  
- TradingView Widget Documentation - https://www.tradingview.com/widget  
- Icons and image credits as noted in the project documentation  
- Stack Overflow for troubleshooting support

---

## Last Updated

November 21, 2025


