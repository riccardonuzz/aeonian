# AEONIAN

This open source project allows to manage IoT sensors in a modular way and makes easy to control each of them.
Features:
* Manage several plants splitting them into environments;
* Share sensor data with third parties;
* Get notified when a setted up exception occurs;
* Manage users;
* Manage sensor's installers.
A user can be and Administrator, an installer or a normal user that monitors sensors.



### Administrator

Administrator can perform following actions:
* Create a user;
* Delete a user;
* Edit a user.

![Administrator Homepage](https://raw.githubusercontent.com/riccardonuzz/aeonian/master/screenshots/screenshot1.jpg)



### Installer

Installer can perform following actions:
* Create plants;
* Delete plants;
* Edit plants;

For each plant:
* Create environments;
* Delete environments;
* Edit environments.

For each environment:
* Add a sensor;
* Edit a sensor;
* Delete a sensor.

A sensor also allows to create a notification: it allows to check wether a condition is met. If so, the user receives an alert on the home page of the dashboard.

![Installer Homepage](https://raw.githubusercontent.com/riccardonuzz/aeonian/master/screenshots/screenshot2.png)



### User

When the user gets into his dashboard, will be able to monitor each sensor that he manage through a plot with the latest readings. Every sensor is under a section representing the environment which has been installed in.
AEONIAN allows user to share sensor's datas with an external source (third part) throught:
* email: user choose an email, all selected sensor's data will be sent there;
* GET/POST: user can coose an endpoint (URL) for sendind data.

![ Homepage](https://raw.githubusercontent.com/riccardonuzz/aeonian/master/screenshots/screenshot3.jpg)

![Administrator Homepage](https://raw.githubusercontent.com/riccardonuzz/aeonian/master/screenshots/screenshot4.jpg)

![Administrator Homepage](https://raw.githubusercontent.com/riccardonuzz/aeonian/master/screenshots/screenshot5.jpg)



# INSTALLATION

This platform requires an Apache server + a MySql database in order to work.
1. Clone this repo and put it into your server's htdocs folder;
2. Load ``` iot_database_4.0.sql ``` database;
3. In the "utente" table create an admin dummy user where Admin role is 1;
4. In order to create a proper password uncomment lines 28-32 from classes/LoginManager.php file;
5. Go into your browser and try to login with the desired user and password;
6. You will get an encoded password, copy and paste it into the database in order to create the user;
7. Comment again lines 28-32 from classes/LoginManager.php file;
You're good to go! :-)

Now you can user the admin user to create an installer user and a normal user.
