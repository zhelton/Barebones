# Barebones
A bare bones wordpress theme and login/registration system

The code assumes the following

Server: localhost
User: root
Password: ''
Database: userdb
Table: users

Table Cols: id,username,pasword,email,bio,gender




Paths:
WordPress Theme: xampp\htdocs\wordpress\wp-content\themes\customtheme

Login\Registration\Index(Homepage): xampp\htdocs\wordpress\userdb

Also assumes a functioning WordPress framework

The user begins at the index page of the WordPress theme where there is a link to the login page. At the login page the user may login with a username and password (will be redirected to the profile page upon successful login)  or choose to follow the link to the registration page. Once a new user is successfully registered the are redirected to the profile page where they will be able to edit their gender and bio.
