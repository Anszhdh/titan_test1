md


 Framework and Tools

div style=display flex
  img src=httpsimg.shields.iobadgeLaravel-FF2D20style=for-the-badge&logo=laravel&logoColor=white 
  img src=httpsimg.shields.iobadgeVue%20js-35495Estyle=for-the-badge&logo=vuedotjs&logoColor=4FC08D 
  img src=httpsimg.shields.iobadgeVite-B73BFEstyle=for-the-badge&logo=vite&logoColor=FFD62E 
  img src=httpsimg.shields.iobadgeTailwind_CSS-38B2ACstyle=for-the-badge&logo=tailwind-css&logoColor=white 
  img src=httpsimg.shields.iobadgeMySQL-005C84style=for-the-badge&logo=mysql&logoColor=white 
div

 Languages

div style=display flex
  img src=httpsimg.shields.iobadgePHP-777BB4style=for-the-badge&logo=php&logoColor=white 
  img src=httpsimg.shields.iobadgeTypeScript-007ACCstyle=for-the-badge&logo=typescript&logoColor=white 
  img src=httpsimg.shields.iobadgeJavaScript-323330style=for-the-badge&logo=javascript&logoColor=F7DF1E 
  img src=httpsimg.shields.iobadgeCSS3-1572B6style=for-the-badge&logo=css3&logoColor=white 
  img src=httpsimg.shields.iobadgeHTML5-E34F26style=for-the-badge&logo=html5&logoColor=white 
div


# Prerequisites

1. [XAMPP](httpswww.apachefriends.orgindex.html) - Make sure to install MySQL server as well during the installation.
2. [Composer](httpsgetcomposer.orgdownload)
3. [NodeJs](httpsnodejs.orgen)
4. [Git](httpsgit-scm.comdownloads) - Watch Youtube in case you are unfamiliar with the git

# Installation

1. Install PHP dependencies for backend

bash
composer install


2. Install NPM dependencies for frontend

bash
npm install


3. Open XAMPP and start Apache and MySQL servers.
4. Copy `.env.example` to `.env`(create new file) and update the database configuration (mysql).
5. Run migration

bash
php artisan migrate


6. Generate application key

bash
php artisan keygenerate


7. Seed the database

bash
php artisan dbseed


8. To link storage with file system

bash
php artisan storagelink


9. Run the application using 2 terminals

bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev