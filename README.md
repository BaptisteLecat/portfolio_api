# Hello, this is an API ! #

This project is my portfolio's REST API developped in PHP.

## To start it on you env ##

You need to have a PHP version upper than 7.4 and Composer installed.

First step run `~ composer install`

Then setup a database : preferably MYSQL.
You need to update the .env, so you can copy it and create a .env.local file and uncomment the MYSQL database connection string.

Run `~ php/bin console doc:doc:status`

Then make `~ php/bin console doc:doc:mig`

## That's all ! ##

Use the swagger.json file and import it in POSTMAN to creates collections.
