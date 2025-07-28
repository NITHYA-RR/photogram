<span style="font-size: 24px;"><b>PHOTOGRAM – SOCIAL MEDIA WEB APP</b></span>

 <p>Photogram is a modern photo-sharing social media platform where users can register, log in, upload photos with captions, like posts, and receive real-time notifications. Built using PHP, JavaScript, MySQL, and RabbitMQ, it is fully responsive and user-friendly.
  </p>

<span style="font-size: 24px;"><b>Project Preview</b></span>

<img src="photogram_preview_collage.png" alt="Photogram Preview" width="100%">

<span style="font-size: 24px;"><b>About the Project🎓</b></span>

<p>
    Photogram is a simple yet powerful social media web app designed for sharing photos.  
    Users can create an account, upload images with captions, like others' posts, and receive real-time notifications.The platform is built using PHP and MySQL with RabbitMQ for instant messaging and updates.It focuses on clean design, responsiveness, and a smooth user experience — ideal for learning full-stack development and real-time web concepts.
</p>

<span style="font-size: 24px;"><b>Key Features ✨</b></span>

<ul>
<li>ser Authentication – Secure sign-up and login system</li>
<li>Photo Upload – Share photos with custom captions</li>
<li>Like System – Like and view other users' posts</li>  
<li>Real-Time Updates – Instant notifications using RabbitMQ</li>  
<li>Responsive Design – Mobile-first layout using Masonry.js</li>  
<li>Optimized Performance – Assets compiled using Grunt</li>
</ul>

<span style="font-size: 24px;"><b>Frontend</b></span>

- HTML, CSS, JavaScript (jQuery), Masonry.js

<span style="font-size: 24px;"><b>Backend</b></span>

- PHP 8.0+
- MySQL database
- php-amqplib (RabbitMQ integration)

<span style="font-size: 24px;"><b>Tools</b></span>

- XAMPP (Apache, MySQL)
- Composer (PHP dependencies)
- Node.js and npm (for Grunt)
- Postman (API testing)
- Git and GitHub (version control)

<span style="font-size: 24px;"><b>Instalation Steps</b></span>

<ul>
<li>Clone the repository</li>
git clone https://github.com/yourusername/photogram.git
</ul>

<ul>
<li>Move the project folder into the htdocs directory</li>
C:\xampp\htdocs\photogram
</ul>

<ul>
<li>Import the database</li>
# Open phpMyAdmin → create a new database → import photogram.sql
</ul>

<ul>
<li>Update database credentials in</li>
libs/includes/Database.class.php
</ul>

<ul>
<li>Install PHP dependencies using Composer</li>
composer install
</ul>

<ul>
<li>Install Node.js dependencies</li>
npm install
# or if you're cool and use pnpm
pnpm install
</ul>

<ul>
<li>nstall and configure RabbitMQ</li>
# Download from: https://www.rabbitmq.com/download.html
# After installing:
# - Enable the management plugin
rabbitmq-plugins enable rabbitmq_management

<p># - Access the dashboard at:</p>

http://localhost:15672 (default username: guest, password: guest)

<p># - Create a virtual host and user (if needed)</p>

</ul>

<ul>
<li>Start Apache and MySQL from XAMPP Control Panel</li>
</ul>

<ul>
<li>Build frontend assets</li>
grunt
</ul>

<ul>
<li>Run your project in the browser</li>
http://localhost/photogram
</ul>

<span style="font-size: 24px;"><b>### 🙌 Final Note</b></span>
Thanks for checking out **Photogram**!  
This project was built to explore full-stack web development with real-time features.  
Feel free to fork, modify, or contribute!.
