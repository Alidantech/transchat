# Web Group Chat

This is a simple web-based group chat website that ensures people don't send inappropriate messages in the group. It uses AJAX for real-time communication and is built with PHP and MySQL for server-side functionalities. Additionally, Font Awesome is used for icons, and the Ratchet WebSocket library is employed for real-time chat functionality.

## Features

- Real-time chat with message filtering.
- User registration and authentication.
- Secure message storage in a MySQL database.
- User-friendly interface with Font Awesome icons.
- Admin features for user management and message moderation.

## Prerequisites

Before setting up the website, make sure you have the following software and dependencies installed:

- [XAMPP](https://www.apachefriends.org/index.html) for Apache, PHP, and MySQL.
- [Composer](https://getcomposer.org/download/) for managing PHP packages.
- [Ratchet WebSocket Library](http://socketo.me/) for real-time chat.

## Installation

Follow these steps to set up the Web Group Chat website on your local environment:

1. **Clone the Repository:**

```bash
      git clone https://github.com/your-username/web-group-chat.git
```

2. Navigate to the Project Directory:

```bash
cd web-group-chat
```
      
3. Install PHP Dependencies:

```bash
composer install
```

4. Start XAMPP:

Start the Apache and MySQL services in XAMPP.

5. Database Configuration:

Create a MySQL database for the application.
Update the config.php file with your database credentials.

6. Run Migrations:

Use the command-line tool or a tool like phpMyAdmin to run database migrations. This will create the necessary tables in your database.

7. Start the WebSocket Server:

Start the Ratchet WebSocket server to enable real-time chat functionality.
```bash
php bin/chat-server.php
```

8. Access the Website:

Open a web browser and navigate to http://localhost/web-group-chat.
Enjoy Chatting:

9. Register an account, log in, and start chatting!

## Usage

* Register an account or log in with an existing one.
* Use the chat interface to send and receive messages in real-time.
* Admins can access moderation features to manage users and messages.
## Contributing

If you would like to contribute to this project, please follow these guidelines:

- Fork the repository on GitHub.
- Create a new branch with a descriptive name.
- Make your changes and commit them with clear messages.
- Push your branch to your fork.
- Submit a pull request to the main branch of the original repository.

## License
     This project has not yet been licensed.