# Airease
## An intergrated ticket booking system that allows you to find cheaper flights to the destinations that you desire 

This project is a semester project that was built to show how to create a airline simple airline system in laravel. every part of this project is sample of code that shows you how to do the following 
* Import the project from the github repository and successfully run it into your device
* How to make it fully functional and install the required dependencies

## How to install this AIREASE laravel project onto your device 
Step 1: Ensure that you have successfully installed composer 
  you can do this by downloading it in the official composer website:https://getcomposer.org/download/

Step 2: Install laravel CLI
  Once you have successfully installed composer, open the CLI/command prompt and run the following command:
  ```command line
composer global require laravel/installer
```
step 3: create a laravel project
once you have installed laravel packages you will be required to create a laravel project named airease
run the following command:
```command line
composer create-project laravel/laravel airease
```
step 4: Configure the laravel
Once you have downloaded the laravel project you will need to change the env. file with the following credentials and create a database with the name : airease

```command line
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=airease
DB_USERNAME=(your username)/root(if no username)
DB_PASSWORD=(your password)
```

  
