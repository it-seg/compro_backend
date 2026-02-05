Egor App (Yii 1) skeleton with login page.

Important steps after extracting:
1. Import the SQL to create users table:
   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) NOT NULL,
       password VARCHAR(255) NOT NULL,
       fullname VARCHAR(100),
       created_at DATETIME DEFAULT CURRENT_TIMESTAMP
   );

   INSERT INTO users (username, password, fullname) VALUES ('admin', MD5('admin'), 'Administrator');

2. Adjust DB credentials in protected/config/main.php if needed.

3. Place this project into your XAMPP htdocs (e.g., D:\xampp\htdocs\egor_app_full) and browse:
   http://localhost/egor_app_full/index.php

4. The yii framework was included from your uploaded zip.

