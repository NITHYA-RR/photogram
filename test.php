# 📱 Social Media Web App

A modern, responsive social media platform built with PHP, JavaScript, and real-time messaging capabilities.

**PHP 8.0+ | jQuery 3.6+ | RabbitMQ 3.8+ | MIT License**

## ✨ Features

• 🔐 **User Authentication**
Secure registration and login system (because security matters)

• 📸 **Photo Sharing**
Upload and share photos with captions (memories are meant to be shared)

• ❤️ **Social Interactions**
Like and interact with posts (spread the love)

• 📱 **Responsive Design**
Works perfectly on all devices (mobile-first approach)

• ⚡ **Real-time Updates**
Live notifications powered by RabbitMQ (no more refreshing)

• 🎨 **Modern UI**
Beautiful Masonry layout with smooth animations (looks fancy)
Loading states (users like feedback)
Mobile responsive (obviously)

• 🛠️ **Asset Pipeline**
Optimized builds with Grunt (because performance matters)

## 🚀 Quick Start

### 📋 Prerequisites

• 🔧 **XAMPP** (PHP, Apache, MySQL/MariaDB)

• 📦 **Composer** (PHP dependency management)

• ⚙️ **Node.js & npm** (for Grunt build system)

• 🐰 **RabbitMQ Server** (for real-time features)

💡 **Pro Tip:** If you're using XAMPP, Apache and MySQL are already included. Just start them from the XAMPP Control Panel.

### 📥 Installation

**Step 1: Clone the repository**

```
git clone <your-repo-url>
cd <your-project-folder>
```

**Step 2: Install PHP dependencies**

```
composer install
```

**Step 3: Install Node.js dependencies**

```
npm install
```

**Step 4: Build assets**

```
grunt
```

**Step 5: Configure database**
• Import the provided SQL file
• Update credentials in libs/includes/Database.class.php

**Step 6: Set up RabbitMQ**
• Install RabbitMQ server
• Update connection settings in your config

**Step 7: Set permissions**

```
chmod 777 uploads/
```

## 💻 Usage

**Step 1: Register** a new account or login with existing credentials

**Step 2: Upload** photos with captions

**Step 3: Like** and interact with posts

**Step 4: Enjoy** real-time updates and notifications

## 🔧 Important Code Snippets

### 💾 Database Connection

```php
// libs/includes/Database.class.php
$host = 'localhost';
$db   = 'your_database';
$user = 'your_username';
$pass = 'your_password';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
```

### 🐰 RabbitMQ Integration

```php
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
// Your RabbitMQ logic here...
```

### 📤 Photo Upload (AJAX)

```javascript
$.ajax({
  url: "api/posts/add.php",
  type: "POST",
  data: new FormData($("#uploadForm")[0]),
  contentType: false,
  processData: false,
  success: function (response) {
    // Handle response
  },
});
```

### ❤️ Like Post (AJAX)

```javascript
$.post("api/posts/like.php", { post_id: 123 }, function (response) {
  // Handle response
});
```

### 🎨 Masonry Layout

```javascript
$(".grid").masonry({
  itemSelector: ".grid-item",
  columnWidth: 200,
});
```

## 🛠️ Development

### ⚙️ Tech Stack

• 🔧 **Backend:** PHP with MySQL

• 🎨 **Frontend:** jQuery, Masonry.js

• ⚡ **Real-time:** RabbitMQ with php-amqplib

• 🔨 **Build Tool:** Grunt for asset optimization

• 📦 **Package Manager:** Composer for PHP dependencies

### ⌨️ Development Commands

**👀 Watch for changes and rebuild**

```
grunt watch
```

**🏗️ Build production assets**

```
grunt build
```

## 📚 Advanced Configuration

### 🐰 RabbitMQ Setup

```php
use PhpAmqpLib\Connection\AMQPStreamConnection;
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
// Configure your queues and exchanges here
```

### 🔐 Environment Variables

Create a `.env` file for sensitive configuration:

```env
DB_HOST=localhost
DB_NAME=your_database
DB_USER=your_username
DB_PASS=your_password
RABBITMQ_HOST=localhost
RABBITMQ_PORT=5672
```

## 🤝 Contributing

**Step 1: Fork** the repository

**Step 2: Create** your feature branch (git checkout -b feature/AmazingFeature)

**Step 3: Commit** your changes (git commit -m 'Add some AmazingFeature')

**Step 4: Push** to the branch (git push origin feature/AmazingFeature)

**Step 5: Open** a Pull Request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🙏 Acknowledgments

• 🎨 **Masonry.js** for the beautiful layout

• 🐰 **php-amqplib** for RabbitMQ integration

• 🔨 **Grunt** for the build system

## 🌟 Connecting to Real APIs

Right now it uses static data. To make it real:

• Update the API routes in `api/posts/`
• Modify database connections in `libs/includes/`
• Update the components to use real data

## 💝 Built with ❤️ and probably too much coffee

If you like this, give it a ⭐ on GitHub! It makes my day 😊

P.S. If you find any bugs, let me know. I'm still learning!

<div align="center">

❤️ **Made with love for the community** ❤️

</div>