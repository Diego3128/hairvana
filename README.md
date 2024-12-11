# Project Setup Guide

Welcome to the hairvana repository! Follow the steps below to set up and execute the project on your local environment.

---

## 1. Install Dependencies

To start, you need to install the required dependencies:

```bash
# Install PHP dependencies (php >8.0)
composer install

# Install Node.js dependencies
npm install
```

---

## 2. Execute the Project

You can execute the project using either PHP's built-in server or Apache:

### Using PHP Local Server
1. Navigate to the `public` folder:
   ```bash
   cd public
   ```
2. Start the PHP server:
   ```bash
   php -S localhost:3000
   ```

### Using Apache
1. Move the project to the `htdocs` folder of your Apache server.
2. Configure the `.htaccess` files:
   - Place a `.htaccess` file in the root of the project.
   - Place another `.htaccess` file in the `public` folder.

For an example of how to configure these files, refer to [this gist](https://gist.github.com/JCervantesB/4ebff26de0d75c3598290d2db351825d).

---

## 3. Set Environment Variables

In the `./includes/` folder, create a `.env` file to define your environment variables. These include database connection details and email settings. Below is an example of how the `.env` file should look:

```env
DB_HOST=localhost
DB_USERNAME=yourusername
DB_PASSWORD=yourpassword
DB_NAME=hairvana

EMAIL_HOST=youremailhost
EMAIL_USERNAME=youremailusername
EMAIL_PORT=2525
EMAIL_PASSWORD=youremailpassword

APP_URL=http://localhost:3000
```

---

## 4. Create Database Tables

To set up the database, import the SQL file located in the root directory of the project:

1. Locate the `./db.hairvana.sql` file.
2. Use your preferred database management tool (e.g., phpMyAdmin or MySQL CLI) to execute the SQL commands and create the necessary tables.

Example using MySQL CLI:
```bash
mysql -u yourusername -p yourpassword hairvana < ./db.hairvana.sql
```

---

## Additional Notes
- Ensure that your PHP version meets the requirements specified in the `composer.json` file.
- Make sure your Apache server has `mod_rewrite` enabled if using Apache to serve the application.
- The `.env` file should not be committed to version control to maintain the security of sensitive information.

If you encounter any issues during setup, feel free to reach out or check the project's issue tracker.

Happy coding!

