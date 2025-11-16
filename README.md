
# Library Management Backend + Admin Panel

## Setup Instructions

1. Import the provided `library.sql` into your MySQL database.
   - Database name: `library`

2. Update `admin/db.php` with your own database username/password if not `root`/empty.

3. Open in browser: `http://localhost/yourproject/admin/login.php`

   - Username: `admin`
   - Password: `kartik@19`

4. On first login, the password will be automatically hashed and stored securely.

5. Admin Pages:
   - Dashboard: View stats (books, members, issued, categories)
   - Books: Manage books
   - Authors: Manage authors
   - Categories: Manage categories
   - Members: Manage students
   - Issued: View issued/returned books
   - Settings: Update admin profile

Enjoy your secure admin panel!
