# Camagru - Web-Based Photo Sharing and Editing Application

Camagru is a **web application** that allows users to **capture, edit, and share photos and videos** using their **webcam** or by uploading images. Users can **superimpose predefined images** with alpha channels onto their photos, share them publicly, and interact with other users by **liking and commenting** on their creations.

This project was built **without any frameworks**, using only **HTML**, **CSS**, **JavaScript**, and **PHP**.

## Table of Contents
- [Tech Stack](#tech-stack)
- [Installation Instructions](#installation-instructions)
- [Features](#features)
- [Environment Files](#environment-files)
- [Creator's Note](#creators-note)

## Tech Stack

**Client:** ![HTML](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white) ![CSS](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white) ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

**Server:** ![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

**Containers:** ![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)

**Database:** ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

**WebServer:** ![Nginx](https://img.shields.io/badge/nginx-%230096D8.svg?style=for-the-badge&logo=nginx&logoColor=white)

## Installation Instructions
To set up and launch this project, follow the detailed steps below:

### Prerequisites
- **Docker**: Necessary to containerize the application.

### Configuration of Environment Files
Before starting the application, you need to configure the necessary environment files for the application to function. Follow the detailed instructions in the [Environment Files](#environment-files) section to create these files.

### Launching the Project
Once the prerequisites are installed and the environment files configured, you can launch the project with the Makefile:
```bash
make
```

## Features
Discover the main features of the application:

### User Features
- **Registration**: Users can sign up with a valid email address, username, and a strong password. Account verification is done via a unique link sent to the provided email address.
- **Login**: Users can log in using their username and password.
- **Password Reset**: Users can request a password reset via email.
- **Profile Management**: Users can modify their username, email address, and password.
- **Logout**: Users can log out from any page with a single click on the logout button.

### Photo Editing
- **Capture and Upload**: Users can capture photos using their webcam or upload an image.
- **Superimpose Images**: Users can select images with alpha channels to superimpose on their photos.
- **Server-Side Processing**: The final image creation is handled on the server side.
- **Delete Images**: Users can delete their own edited images.

### Gallery Features
- **Public Gallery**: Displays all edited images by all users, ordered by creation date.
- **Interaction**: Logged-in users can like and comment on images.
- **Notifications**: Image authors are notified by email when their image receives a new comment (can be deactivated in user preferences).
- **Pagination**: The gallery is paginated with 5 images per page.

### Security Features
- **Form Validation**: All forms include proper validation.
- **Account Protection**: Passwords are encrypted, and the application protects against SQL injection, CSRF, and XSS attacks.

## Filters
Users can apply filters to their images, such as:
- **John Cena**
![John Cena](src/Media/Filters/Cena/cena300.png)
- **Joe Dassin**
![Joe Dassin](src/Media/Filters/Dassin/dassin300.png)
- **Johnny Halliday**
![Johnny Halliday](src/Media/Filters/Halliday/halliday300.png)
- **Johnny Knoxville**
![Johnny Knoxville](src/Media/Filters/Knoxville/knoxville300.png)
- **John Lennon**
![John Lennon](src/Media/Filters/Lennon/lennon300.png)
- **Joe Pesci**
![Joe Pesci](src/Media/Filters/Pesci/pesci300.png)

## Environment Files
The application requires environment files to function properly. These files contain essential information that must not be disclosed publicly.

```
HOSTNAME= // Hostname for the application.
DB_NAME= // Name of the database for the application.
DB_USERNAME= // Username to access the database.
PASSWORD_DB= // Password for the database user.
UID= // User ID for permissions.
GID= // Group ID for permissions.
image_width_min=400
image_height_min=400
PHP_MAIL_USER= // Email address used for automated email sending.
PHP_MAIL_PASSWORD= // Password for the email address used for sending emails.
```

**Note:** *The email address used for sending emails must be a gmail address. You must configure your Google account associated with this email address to allow less secure apps to access it.*

## Creator's Note
This project was made with ❤️ by [cgangaro](https://github.com/cgangaro).

If you found this project and README helpful, please consider giving it a ⭐ and following me!

Connect with me on [LinkedIn](https://fr.linkedin.com/in/camille-gangarossa-2ab929227)!

Feel free to reach out with any questions.