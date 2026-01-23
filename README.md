# CamelLibrary Management System

A premium, full-featured Library Management System built with PHP and SQLite. This project implements a complete SCRUD (Search, Create, Read, Update, Delete) lifecycle for managing textbooks, featuring a modern glassmorphism UI.

## 🚀 Features

- **Full SCRUD Implementation**: Search, Add, View, Edit, and Delete books.
- **Secure Authentication**: User registration and login with password hashing.
- **Auto-Seeding Database**: Automatically populates with 10 legendary books on first run.
- **Premium UI**: Modern design using Inter fonts, FontAwesome icons, and Glassmorphism effects.
- **Responsive Design**: Flawless experience across desktop and mobile devices.

---

## 🛠️ Technical Architecture

### 1. Database Implementation (`sqlite`)
The system uses **SQLite**, a serverless database stored in `camellibrary.sqlite`.

- **Configuration (`config/database.php`)**:
  - Automatically creates the `users` and `textbooks` tables if they don't exist.
  - **Auto-Seeding**: If the `textbooks` table is empty, the system automatically inserts 10 pre-defined books (e.g., Napoleon Hill, Earl Nightingale).
- **PDO Integration**: Uses PHP Data Objects (PDO) for secure, prepared SQL statements to prevent SQL injection.

### 2. Authentication Flow
The security system ensures that only registered users can access the library management features.

- **Registration (`register.php`)**:
  - Collects username and password.
  - Uses `password_hash()` with the `PASSWORD_DEFAULT` algorithm to securely encrypt passwords before storing them.
- **Login (`login.php`)**:
  - Verifies credentials using `password_verify()`.
  - Establishes a secure session using `session_start()`.
- **Global Auth Guard**: All protected pages (Home, Textbooks) check for an active `$_SESSION['username']`. If missing, the user is redirected to the login page.
- **Logout (`logout.php`)**: Destroys the session and redirects to the login screen.

### 3. Textbooks SCRUD (`textbooks.php`)
This is the core engine of the application, managing the book collection.

- **S (Search)**: A dynamic filter that queries the database using `LIKE` operators to find books by title or author.
- **C (Create)**: A modern form that adds new entries to the `textbooks` table using prepared statements.
- **R (Read)**: A responsive table that fetches and displays the current book list, including ID, Title, and Author.
- **U (Update)**: A smart "Edit Mode" integrated into the main page. It pre-populates the form with existing data, allowing users to save changes instantly.
- **D (Delete)**: Removes entries with a JavaScript confirmation prompt to prevent accidental deletions.

---

## 🎨 Design System

The application uses a custom-built CSS framework (`css/style.css`):
- **Fonts**: Inter (Google Fonts) for a modern, clean look.
- **Icons**: FontAwesome 6 for intuitive navigation.
- **Visuals**: 
  - Glassmorphism containers with `backdrop-filter: blur()`.
  - Subtle gradients and shadows for depth.
  - Transitions and hover states for improved interactivity.

---

## 📂 Project Structure

```text
lesson2/
├── config/
│   └── database.php      # DB connection & Seeding
├── css/
│   └── style.css         # Premium UI styles
├── templates/
│   ├── header.php        # Navigation & Meta items
│   └── footer.php        # Site footer
├── index.php             # Landing redirect
├── register.php          # User registration
├── login.php             # User login
├── logout.php            # Session termination
├── home.php              # User Dashboard
├── textbooks.php         # Core SCRUD functionality
└── camellibrary.sqlite   # SQLite Database file
```

## 📝 Assignment Requirements Met
- [x] Complete CRUD functionality.
- [x] 10 pre-inserted books (Napoleon Hill, etc.).
- [x] Secure user authentication system.
- [x] High-quality, responsive UI.

---
*Created for the Library Management Assignment.*
