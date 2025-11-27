# Institutional Trading Center  
_Financial Positions Management Web Application_

![GitHub last commit](https://img.shields.io/github/last-commit/danbarbos/InstitutionalTradingCenter)
![License](https://img.shields.io/badge/license-MIT-green)

<img width="1057" height="504" alt="image" src="https://github.com/user-attachments/assets/e129663a-0188-40e9-b648-beb16c31b83a" />
  
---

## Project Overview

A robust, web-based application for managing financial positions and trading activities in an institutional setting, developed for the Databases course at TUCN. It features secure authentication, real-time market data integration via TradingView widgets, and intuitive tracking of portfolios, trades, and counterparties.

---

## Key Features

* **Secure & Interactive Dashboard:** Session-based user authentication with TradingView widgets for market heatmaps and news.
* **Comprehensive Financial Management:** CRUD operations for Portfolios, Institutions, Counterparties, and Trade Operations (Add/Close Position).
* **Role-Based Access Control:** Separation of access between regular users (personal data) and Admins (full system data management).
* **Tech Stack:** Built with **PHP** (Backend), **Microsoft SQL Server** (Database), and **HTML/CSS/JS** (Frontend).

---

## 🛠️ Installation & Setup

### Prerequisites
- PHP 7.x or later
- Microsoft SQL Server
- Web server (Apache or IIS)

### Setup Instructions

1.  **Clone the repository:** `git clone ...`
2.  **Database:** Restore the provided backup file `Institutional Trading Center.bak` or run the scripts in the `itc queries` folder on your SQL Server instance.
3.  **Configuration:** Update the database connection settings in **`dbconfig.php`** (server name, user, password).
4.  Deploy files to your web server and access `login.php`.

---

## 📂 File Structure Highlights

* **`dbconfig.php`**: Database connection settings.
* **`login.php` / `dashboard.php`**: Main application logic and routing.
* **`admin/`**: Admin-only CRUD interfaces.
* **`views/`**: UI components for different sections.

---

## 🔗 Further Documentation

| Topic | File |
| :--- | :--- |
| **Detailed User Guide** | [USAGE.md](USAGE.md) |
| **Troubleshooting & FAQs** | [TROUBLESHOOTING.md](TROUBLESHOOTING.md) |
| **Security Principles** | [SECURITY.md](SECURITY.md) |

---


