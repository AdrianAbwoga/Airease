# Airease
## An intergrated ticket booking system that allows you to find cheaper flights to the destinations that you desire 

This project is a semester project that was built to show how to create a airline simple airline system in laravel. every part of this project is sample of code that shows you how to do the following 
* Import the project from the github repository and successfully run it into your device


## How to install this AIREASE laravel project onto your device 
Step 1: Ensure that you have successfully installed composer 
  you can do this by downloading it in the official composer website:https://getcomposer.org/download/

Step 2: Install laravel CLI
  Once you have successfully installed composer, open the CLI/command prompt and run the following command:
  ```command line
composer global require laravel/installer
```
step 3: clone the repository 
to clone this repositry select the correct location you want to store this refferably in the C:\xampp\htdocs file route 
run this code in the console 
```command line
git clone git@github.com:AdrianAbwoga/Airease.git
```
Switch to the repo folder
```
cd Airease
```
install all the necessary dependencies 
```
composer install
```
Copy all the example env file and make the required configuration changes to the env.file 

the necessarry configurations for potimal functionallity is explained in step 4 

step 4: Configuring the database
Once you have downloaded the laravel project you will need to change the env. file with the following credentials and create a database with the name : airease

```command line
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=airease
DB_USERNAME=(your username)/root(if no username)
DB_PASSWORD=(your password)
```

Step 5: Generating the application key
to generate the key simply run this command in your environment 
```
php artisan key:generate
```
Step 6: run the database migrations
simply run the following command to run migrations 
```
php artisan migrate
```

once you are done you can populate the database with the credentials you wish. another option is to seed the information in the seeder implemented to do so run the following command(note this Seeder provides a limit of 15 seeded information)
```
php artisan db:seed
```
Final: running the code
to run the code simply run the following command 
```
php artisan serve
```
## sample images of how it should appear 
### admin login 

![Screenshot (129)](https://github.com/AdrianAbwoga/Airease/assets/98470631/ef0a60bd-8430-4d5f-8723-8e80a9f922b2)

### User Login

![Screenshot (128)](https://github.com/AdrianAbwoga/Airease/assets/98470631/bc864513-bb74-4c49-8208-bf91b81186ca)

### User Register

![Screenshot (127)](https://github.com/AdrianAbwoga/Airease/assets/98470631/391099d1-2f43-45c4-9f5b-09ecaa01b7eb)

 
