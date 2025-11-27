# 🧑‍💻 Usage Guide

This guide provides instructions on how to use the Institutional Trading Center application as both a regular user and an administrator.

## Accessing the Application

1.  Open the application in your browser via the login page (`login.php`).
2.  Enter your credentials to log in.

## For Regular Users

Upon logging in, users are directed to the main **Dashboard**.

### The Dashboard

* **Personalized Welcome:** Displays a personalized greeting.
* **Market Monitoring:** Features embedded TradingView widgets for:
    * Market Heatmaps
    * Stock Charts
    * Latest Financial News
    * Economic Calendar
* **Navigation:** Use the dashboard menus to access different management views.

### Trade Operations

The Trade interface allows users to manage their financial positions:

* **Add New Trades:** Initiate a new trade, defining the instrument, quantity, and other relevant parameters.
* **Close Positions:** Select an open position and execute the closing trade to realize profits or losses.
* **Position Tracking:** View all current open and historical closed trades.

### Data Management

* **Portfolios:** View the details and performance of your assigned portfolios.
* **Institutions & Counterparties:** Access read-only information about the institutions and counterparties associated with your trades.

## For Administrators

Administrators have elevated privileges and access to system-wide data management.

### Accessing Admin Features

* Log in with an account that has the designated administrator role assigned in the users database table.
* Special admin menus will be available on the dashboard or via direct routing.

### Full CRUD Operations

Administrators have **Full CRUD (Create, Read, Update, Delete)** access for maintaining system integrity:

* **Manage Portfolios:** Add new portfolios, edit details of existing ones, or remove obsolete portfolios.
* **Manage Institutions:** Maintain the list of financial institutions involved.
* **Manage Counterparties:** Handle the data for all counterparties the trading center interacts with.

### System Oversight

* Administrators can oversee all users’ activities and ensure data consistency across the application.
