
# 🛍️ Laravel Product Management System

A complete **Laravel Product & Category Management System** built with **Laravel, PHP, MySQL, Blade, Bootstrap, and JavaScript**. This project demonstrates CRUD operations, authentication, role-based access, product management, image handling, filtering, bulk actions, soft deletes, dashboards, and many advanced Laravel features.

---

# 🚀 Tech Stack

* Laravel
* PHP
* MySQL
* Blade
* Bootstrap 5
* JavaScript
* Eloquent ORM

---

# ✨ Features

## 🔐 Authentication

* User Registration
* User Login
* Automatic Login after Registration
* Logout
* Role-based Authentication (Admin & User)

---

# 👤 Admin Features

## 📂 Category Management

* Create Category
* Edit Category
* Delete Category
* Prevent deleting category if products exist
* Active / Inactive Status

---

## 📦 Product Management

* Create Product
* Edit Product
* Delete Product
* Soft Delete Support
* Restore Product
* Permanently Delete Product
* Product Status

  * Active
  * Inactive
  * Draft

---

## 🖼️ Product Images

* Multiple Image Upload (Maximum 5 Images)
* Individual Image Delete
* Default Image Placeholder
* Image Preview Before Upload
* Image Thumbnail Listing
* Large Image Preview on Hover

---

## 🏷️ SKU Management

* Automatic SKU Generation

Example:

```
PRD-0001
PRD-0002
PRD-0003
```

* Search by SKU

---

## 📊 Dashboard

Dashboard includes:

* Total Products
* Total Categories
* Active Products
* Out of Stock Products
* Total Inventory Value
* Current Stock Summary

---

## 📋 Product Listing

* Pagination
* Product Thumbnail
* Category Name
* SKU
* Product Status
* Created Date
* Responsive Table

---

## 🔍 Search & Filters

* Search by Product Name
* Search by SKU
* Filter by Category
* Filter by Status
* Price Range Filter
* Sort Price (Ascending / Descending)

---

## 📦 Bulk Actions

* Select Multiple Products
* Bulk Status Update

  * Active
  * Inactive
  * Draft
* Bulk Delete

---

## 📈 Inventory Features

* Low Stock Badge
* Stock Highlight
* Inventory Value Calculation

---

## 📤 Export

* Export Filtered Products to CSV

---

## 🗑️ Trash Management

* Soft Delete
* Trash Page
* Restore Product
* Permanently Delete Product

---

## 📄 Product Details

Each product has a dedicated details page displaying:

* Product Images
* SKU
* Category
* Price
* Stock
* Status
* Created Date

---

## 📑 Duplicate Product

* Duplicate Existing Product
* Automatically Generate New SKU

---

# 👥 User Features

* Separate User Dashboard
* View Active Products Only
* Product Details Page
* Product Filters
* Shopping Cart
* Responsive UI

---

# 🎨 UI Features

* Responsive Design
* Bootstrap Cards
* Responsive Tables
* Loading Indicator
* Image Preview
* Hover Image Preview
* Delete Confirmation
* Toast Success & Error Messages

---

# 🛠️ Validation

### Laravel Validation

* Required Fields
* Image Validation
* Category Validation
* Price Validation
* Stock Validation

### JavaScript Validation

* Price must be greater than 0
* Stock cannot be negative
* Delete Confirmation
* Image Preview Before Upload

---

# 📁 Project Structure

```
app/
├── Models
├── Http
│   ├── Controllers
│   └── Middleware
├── Mail

resources/
├── views
│   ├── products
│   ├── categories
│   ├── dashboard
│   └── layouts

public/
├── storage/
```

---

# ⚙️ Installation

Clone the repository

```bash
git clone https://github.com/your-username/product-management-system.git
```

Go to project directory

```bash
cd product-management-system
```

Install dependencies

```bash
composer install
```

Create environment file

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Configure database in `.env`

Run migrations

```bash
php artisan migrate
```

Create storage link

```bash
php artisan storage:link
```

Start the server

```bash
php artisan serve
```

---

# 📚 Learning Outcomes

This project demonstrates practical experience with:

* Laravel CRUD Operations
* Authentication
* Role-Based Authorization
* Eloquent Relationships
* File Uploads
* Multiple Image Management
* JavaScript DOM Manipulation
* Bootstrap UI
* Filtering & Searching
* Pagination
* Bulk Operations
* Soft Deletes
* CSV Export
* Session Management
* Responsive Design

---

# 📌 Future Improvements

* Wishlist
* Product Reviews
* Orders
* Checkout System
* Payment Gateway Integration
* Inventory Reports
* Product Analytics
* Email Notifications
* REST API
* Admin Activity Logs

---

# 👨‍💻 Author

Developed using **Laravel, PHP, MySQL, Blade, Bootstrap, and JavaScript** as a learning project to strengthen full-stack web development skills.
