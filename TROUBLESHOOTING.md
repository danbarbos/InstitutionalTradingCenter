# ⁉️ Troubleshooting & FAQs

This guide helps resolve common issues encountered during the installation or usage of the Institutional Trading Center application.

## Database Connectivity Issues

If the application fails to connect to the database or displays an error upon login/load:

* **Check `dbconfig.php`:** Verify that the `$serverName`, `"Database"`, `"Uid"`, and `"PWD"` values are correct for your local or remote Microsoft SQL Server instance.
* **Database Service Status:** Ensure your Microsoft SQL Server service is running.
* **Permissions:** Confirm that the user defined in `dbconfig.php` (`"Uid"`) has the necessary permissions to connect to and interact with the database named "Institutional Trading Center".

## Login and Authentication

* **Credentials:** Double-check the user credentials. Ensure the user exists in the database's users table.
* **PHP Session:** If you are repeatedly redirected to the login page after logging in, verify that PHP sessions are correctly configured on your web server and that the application has permissions to write session data.
* **Session Expiration:** Sessions expire due to inactivity. If you are logged out unexpectedly, simply re-login.

## TradingView Widget Errors

If the embedded market data widgets are blank or fail to load:

* **Network Access:** Confirm that your server and client machines have unrestricted network access to the TradingView widget URLs (`https://www.tradingview.com/...`).
* **Security Policies:** Check for any Content Security Policy (CSP) headers or browser extensions that might be blocking the external script loads.

## General Errors and Debugging

* **PHP Error Logs:** Review your web server's PHP error logs (e.g., `php_error.log`) for detailed stack traces or fatal errors. This is the first place to look for backend issues.
* **Browser Console:** Use your browser's developer tools (F12) to check the Console tab for JavaScript errors or network issues when interacting with the application.
