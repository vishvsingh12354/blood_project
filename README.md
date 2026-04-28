# 🩸 Blood Donation Management System

A secure, web-based Blood Donation Management System developed for DBMS Laboratory. It enables admins to manage donors, monitor blood inventory, handle patient requests, and visualize blood group distribution through a real-time dashboard.

![Blood Donation Management System](https://img.shields.io/badge/Blood_Donation-Management_System-red)
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?logo=mysql)
![XAMPP](https://img.shields.io/badge/XAMPP-Apache_Server-FB7A24?logo=xampp)

## 👥 Project Members

| Sr | Name | Roll Number |
|----|------|-------------|
| 1 | Vishv Singh | RA2411030030049 |
| 2 | Abhishek Bhardwaj | RA2411030030071 |

## 📁 Project Documents

| Sr | Description | Link |
|----|-------------|------|
| 1 | Project Code | [View](https://github.com/vishvsingh12354/blood_project/tree/main/blood_project) |
| 2 | Project Report | [View](https://github.com/vishvsingh12354/blood_project/blob/main/Blood_Donation_Management_System_Report%20(3).docx) |
| 3 | Final PPT | [View](https://github.com/vishvsingh12354/blood_project/blob/main/Blood-Donation-Management-System%20(1)%20(2)%20(1).pptx) |
| 4 | RA2411030030049_Certificate | [View](https://github.com/vishvsingh12354/blood_project/blob/main/vishv%20singh%20certificate.jpeg) |
| 5 | RA2411030030071_Certificate | [View](https://github.com/vishvsingh12354/blood_project/blob/main/Abhishek%20certificate.png)) |
| 6 | RA2411030030049_CourseReport | [View](https://github.com/vishvsingh12354/blood_project/blob/main/DBMS_Course_Report_vishv%20singh%20(1).docx) |
| 7 | RA2411030030071_CourseReport | [View](https://github.com/vishvsingh12354/blood_project/blob/main/DBMS_Course_Report_abhishek%20bhardwaj.docx) |

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Running the Application](#running-the-application)
- [Project Structure](#project-structure)
- [Screenshots](#screenshots)
- [DBMS Concepts Demonstrated](#dbms-concepts-demonstrated)
- [Future Enhancements](#future-enhancements)

## ✨ Features

### Admin Features
- 🔐 Secure Authentication — Login/logout with PHP session management and timed expiry
- 👤 Donor Management — Full CRUD operations: register, view, edit, and delete donor records
- 🩸 Blood Inventory — Monitor blood stock levels per group and location with critical-level alerts
- 📋 Request Queue — View and approve patient blood requests in real time
- 👨‍⚕️ Staff Management — View authorized personnel with role-based clearance levels
- 📊 Dashboard — Real-time doughnut chart visualization of blood group distribution

### Security
- Session-based access control on all admin pages
- Server-side input validation and sanitization via `mysqli_real_escape_string`
- Parameterized-style queries to reduce SQL injection risk
- Immediate redirect to login on unauthorized access attempts

### User Interface
- High-tech dark theme with neon accents across all admin panels
- Animated fade-in transitions and interactive table hover effects
- Critical inventory alerts with pulsing red highlights for low-stock blood groups
- Responsive sidebar navigation with active-state indicators

## 🛠 Tech Stack

### Backend & Core
- **PHP** — Backend logic, form handling, and session management
- **MySQL** — Relational database for donors, users, inventory, and requests
- **XAMPP** — Apache server and MySQL for local development and deployment

### Frontend
- **HTML5 + CSS3** — Custom dark-themed responsive UI
- **Chart.js** — Interactive doughnut chart for blood group distribution dashboard
- **Google Fonts (Orbitron + Roboto Mono)** — Futuristic typography across admin panels

## 📋 Prerequisites

- XAMPP (or any Apache + MySQL stack)
- PHP 7.4 or higher
- A modern web browser

## 💻 Installation

**Step 1: Clone the Repository**
```bash
git clone https://github.com/your-username/Blood-Donation-Management-System.git
```

**Step 2: Move to XAMPP's web root**
```bash
cp -r Blood-Donation-Management-System/ /xampp/htdocs/blood_donation/
```

**Step 3: Set up the Database**
- Open **phpMyAdmin** at `http://localhost/phpmyadmin`
- Create a new database named `blood_donation_db`
- Import the provided SQL file to set up tables (`donors`, `users`, `blood_bank`, `requests`, `staff`)

**Step 4: Configure Database Connection**

Edit `db.php` if your credentials differ:
```php
$host   = "localhost";
$user   = "root";
$pass   = "";
$dbname = "blood_donation_db";
```

## 🚀 Running the Application

**Step 1:** Start Apache and MySQL from the XAMPP Control Panel

**Step 2:** Open your browser and navigate to:
```
http://localhost/blood_donation/index.php
```

**Step 3:** For the admin panel, go to:
```
http://localhost/blood_donation/login.php
```

## 📁 Project Structure

```
blood_donation/
├── index.php               # Public donor registration form
├── login.php               # Admin authentication page
├── logout.php              # Session destruction and redirect
├── db.php                  # Database connection config
├── view_donors.php         # Admin dashboard with donor list and chart
├── edit_donor.php          # Edit existing donor records
├── delete_donor.php        # Delete donor by ID
├── blood_inventory.php     # Blood stock monitoring panel
├── view_request.php        # Patient blood request queue
├── approve_request.php     # Approve pending requests
└── staff_management.php    # Authorized personnel list
```

## 📊 DBMS Concepts Demonstrated

- Relational Database Design with normalized tables
- Primary Keys, Foreign Keys & Referential Integrity
- Full CRUD Operations (Create, Read, Update, Delete)
- Session-based Authentication and Access Control
- Aggregate Queries (`COUNT`, `GROUP BY`) for dashboard analytics
- Input Sanitization to prevent SQL Injection

## 🔮 Future Enhancements

- SMS/Email alerts to notify eligible donors automatically
- GPS-based donor search for emergency proximity matching
- Role-auditing logs for compliance and accountability
- Soft-delete option to preserve donor history in the archive
- Multi-center rollout support for hospital network deployment
- Export donor and inventory reports to CSV/PDF
