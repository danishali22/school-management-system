# 📚 School Management System

A complete school management system built with **Core PHP**, **MySQL**, and **Bootstrap** to manage all essential academic and administrative activities for schools. This was my **Final Year Project (FYP)** at **GC University Lahore**, designed to streamline processes like student enrollment, attendance tracking, grading, and communication.

---

## 🚀 Features

* 👨‍🎓 **Student Enrollment** – Manage student records, registrations, and profiles.
* 📋 **Attendance Tracking** – Monitor daily attendance and generate reports.
* 🎓 **Grade Management** – Record, update, and calculate grades with GPA logic.
* 📢 **Communication Portal** – Deliver announcements and messages to students and parents.
* 🧑‍💼 **Admin Dashboard** – Oversee teachers, students, classes, and subjects.

---

## 🛠️ Technologies Used

* PHP (Core PHP – without frameworks)
* MySQL
* Bootstrap (Responsive UI)
* HTML, CSS, JavaScript

---

## 🏗️ Folder Structure with Comments

```bash
school-management-system/
├── index.php                 # Entry point and dashboard loader
├── login.php                 # Login screen for different user roles
├── logout.php                # User logout handler
├── db.php                    # Database connection file
├── config.php                # Global configuration and constants
├── assets/                   # Static files like images, icons, fonts, and vendor JS
│   ├── css/                  # All global and custom stylesheets
│   ├── js/                   # JavaScript for interactivity and validation
│   └── images/               # App icons, logos, and user avatars
├── includes/                 # Shared layout and structure partials
│   ├── header.php            # HTML head with meta, CSS includes
│   ├── navbar.php            # Top navigation bar (role-based)
│   ├── sidebar.php           # Left sidebar with menu
│   └── footer.php            # Footer HTML and closing tags
├── modules/                  # Feature-specific logic
│   ├── students/             # Student registration, update, and view logic
│   │   ├── add_student.php
│   │   ├── edit_student.php
│   │   └── view_students.php
│   ├── teachers/             # Manage teacher records
│   ├── classes/              # Manage classes and sections
│   ├── attendance/           # Mark and view attendance
│   ├── grades/               # Record and calculate grades
│   ├── subjects/             # Subject listings and assignment
│   └── announcements/        # Publish announcements or notices
├── admin/                    # Admin-only functionality
│   ├── dashboard.php         # Admin landing page
│   └── manage_users.php      # User (staff/teacher) CRUD
├── student/                  # Student dashboard and features
│   └── profile.php           # View student profile and grades
├── teacher/                  # Teacher dashboard and grading tools
│   └── mark_attendance.php
└── README.md                 # Project documentation (you’re reading it!)
```

---

## 💡 Challenges Faced

* Building a full-stack app without PHP frameworks
* Implementing role-based permissions cleanly
* Structuring reusable UI with Bootstrap
* Optimizing SQL queries for multi-user concurrency

---

## 🧠 Key Learnings

* Deepened understanding of backend logic in raw PHP
* Strengthened frontend skills with Bootstrap
* Practiced building a scalable database schema
* Learned to implement clean session management and CRUD operations

---

**Developed by [Danish Ali](https://github.com/danishali22) as FYP @ GC University Lahore**
