# RA BeautyCare - Admin Dashboard

RA BeautyCare is a PHP & MySQL-based Admin Dashboard developed to manage the content of the RA BeautyCare website.

The system allows the administrator to manage products, categories, services, About Us content, appointments, users, and user passwords through an easy-to-use dashboard.

---

## Features

### Admin Authentication
- Admin login and logout.
- Session-based authentication.
- Password verification using `password_verify()`.
- Passwords are stored securely using `password_hash()`.

### Dashboard
- Display total number of products.
- Display total number of categories.
- Display total number of services.
- Display total number of appointments.
- Display total number of users.
- Dashboard statistics and charts.

### Categories Management
The administrator can:

- Add categories.
- Edit categories.
- Delete categories.
- Upload category images.
- Display category images.
- Assign a user to a category.

### Products Management
The administrator can:

- Add products.
- Edit products.
- Delete products.
- Upload product images.
- Add product descriptions.
- Set product prices.
- Assign products to categories.

Products are connected to categories using the `categories_id` field.

### Services Management
The administrator can:

- Add services.
- Edit services.
- Delete services.
- Add service descriptions.
- Add service icons.
- Activate or deactivate services.

Only active services are displayed on the frontend website.

### About Us Management
The administrator can manage:

- About Us title.
- First text section.
- Second text section.
- About Us image.

The frontend retrieves the About Us information directly from the database.

### Appointments
The system allows the website to receive appointment requests.

Appointment information includes:

- Customer name.
- Phone number.
- Service.
- Appointment date.
- Appointment time.
- Notes.

The administrator can view and delete appointments from the dashboard.

### Users Management
The administrator can:

- Add users.
- Edit users.
- Delete users.
- View users.
- Change user passwords.

### Change Password
The administrator can change a selected user's password.

The process is:

1. Select a user.
2. Click the Change Password button.
3. Enter the new password.
4. Confirm the password.
5. Validate the password.
6. Hash the password using `password_hash()`.
7. Save the new password in MySQL.
8. Login using the new password.

Passwords are never stored as plain text.

---

# Project Structure

```text
RA_BeautyCare/
│
├── ra_admin/
│   │
│   ├── common/
│   │   ├── footer.php
│   │   ├── head.php
│   │   ├── navbar.php
│   │   ├── script.php
│   │   └── sidebar.php
│   │
│   ├── css/
│   │
│   ├── img/
│   │
│   ├── js/
│   │
│   ├── lib/
│   │
│   ├── index/
│   │   ├── index.php
│   │   ├── login.php
│   │   ├── logout.php
│   │   ├── conn.php
│   │   ├── users.php
│   │   ├── categories.php
│   │   ├── products.php
│   │   ├── services.php
│   │   ├── about_us.php
│   │   ├── appointments.php
│   │   ├── update_password.php
│   │   └── ...
│   │
│   ├── raweb/
│   │   └── index.php
│   │
│   └── uploads/
│       ├── products/
│       ├── categories/
│       └── about/
│
├── database/
│   └── ra_beautycare.sql
│
├── README.md
│
└── .gitignore
