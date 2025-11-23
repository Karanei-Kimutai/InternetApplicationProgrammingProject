Project Startup & Architecture Guide
-----------------------------------------
This document serves two purposes:

The Creation Log: A step-by-step history of how this project was built from an empty folder.

The Setup Manual: A human-friendly guide to understanding and starting the dual-database architecture.

---------------------------------------------

Part 1: The Creation Story (Dev Log)
----------------------------------------------
This project didn't just appear; it was built in 5 key stages. Here is the reconstruction of the development timeline:

Step 1: The Skeleton (Genesis)
We started by initializing a fresh Laravel framework to handle the heavy lifting (routing, security, MVC structure).

Command: composer create-project laravel/laravel InternetApplicationProgrammingProject

Result: A standard Laravel directory structure was created.

Step 2: The Toolbelt (Dependencies)
 We realized the app needed specific tools that Laravel doesn't provide out of the box.

Action: Added simplesoftwareio/simple-qrcode for generating pass codes and phpmailer/phpmailer for robust email delivery.

Config: We also modified config/database.php here to define the "University" connection.