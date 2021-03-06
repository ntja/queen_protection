# Steps to start application and trigger requests

- Clone/download the project and place it on the root of the web server

- Start your web server

- Install and Open Postman to trigger API requests. Import the collection **protect_the_queen.postman_collection** into postman to have some requests and start testing different endpoints. You can write your own requests too.


## Documentation and Unit test cases

The API-doc, Postman-collection file, Data model and description documentation are located in the **/documentation** folder.

The bash file to run unit test cases is locate on root directory and named **run-test-cases.sh** for linux environnement and **run-test-cases.bat** for Windows environnement. Testing classes are location in **/tests/Feature** folder

### Description of the architecture of Laravel and how it works.

The framework Laravel was used to achieve that challenge. Here is a description of its architecture and how it works.

The root directory contains a variety of folders:
-	The **App directory** contains the core code of the application. Almost all of the classes in the application are in this directory. 
Inside that directory we have **The Http directory which contains controllers, middleware, and form requests**. Almost all of the logic to handle requests entering the application will be placed in this directory.

-	The **Bootstrap directory** contains files that bootstrap the framework and configure auto loading. This directory also houses a cache directory which contains framework generated files for performance optimization such as the route and services cache files.

-	The **Config directory** contains all of application's configuration files.

-	The **Database directory** contains database migration and seeds.

-	The **Public directory** contains the index.php file, which is the entry point for all requests entering the application. This directory also houses assets such as images, JavaScript, and CSS.

-	The **Resources directory** contains views as well as raw, un-compiled assets such as LESS, SASS, or JavaScript. This directory also houses all of language files.

-	The **Routes directory** contains all of the route definitions for your application. By default, several route files are included with Laravel:  web.php, api.php, console.php and channels.php.
•	The web.php file contains routes that the RouteServiceProvider places in the web middleware group, which provides session state, CSRF protection, and cookie encryption. If the application does not offer a stateless, RESTful API, all of your routes will most likely be defined in the web.php file.
•	The api.php file contains routes that the RouteServiceProvider places in the api middleware group, which provides rate limiting. These routes are intended to be stateless, so requests entering the application through these routes are intended to be authenticated via tokens and will not have access to session state.
•	The console.php file is where we may define all of Closure based console commands. Each Closure is bound to a command instance allowing a simple approach to interacting with each command's IO methods. Even though this file does not define HTTP routes, it defines console based entry points (routes) into your application.
•	The channels.php file is where you may register all of the event broadcasting channels that your application supports.

-	The **Storage directory** contains compiled Blade templates, file based sessions, file caches, and other files generated by the framework. This directory is segregated into app, framework, and logs directories. The app directory may be used to store any files generated by the application. The framework directory is used to store framework generated files and caches. Finally, the logs directory contains the application's log files.

-	The **Tests directory** contains your automated tests.

-	The **Vendor directory** contains all Composer dependencies.

-	I added the **Documentation directory** which contains all the documentation regarding that challenge.


#### Requirements

- PHP >=7.0
