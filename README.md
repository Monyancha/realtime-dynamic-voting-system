# Dynamic Voting System - Realtime

## Description 
> Dynamic Voting System for Gordon College - College of Computer Studies. Dynamic list of positions, restriction on votes courses. Realtime voting results.

## Configuration
> Configure your database connections and project user account at.
```
/config.php
```
```
Step 1: Setup Configuration
	- Edit config.php
	- Modify database's username
	- Modify database's password
	- Modify application's administrator account
	- Modify application's administrator account

Step2: Starting the server
	- Launch start_apache_server.bat
	- Launch start_socket_server.bat
	- Don't close the cmd windows

Step3: Uploading Student Records
	- Sample csv file is in resouces/folder/db.csv
```

## Deployment
> Run it in your server such as xampp, wamp or hosted server. 
> Run the following files:
```
start_apache_server.bat
start_socket_server.bat
```
> Don't close the terminal windows. Because it serves the project application into the server.
    
## Import of Records
> Upload CSV file that contains field of the following.
```
'unique_id', 'person_name', 'organization', 'level'
```

## Reports
> Login as administrator and proceed to report section. Click the 'printer' icon and save as pdf.

## Technical Background
> The following are the technologies used in this project.
``` 
PHP | MySQL | Node JS | HTML5 | JavaScript | CSS3 | Materialize
```