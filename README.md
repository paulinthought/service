For CurrencyFair:

Install using composer
Run npm install and npm start from ./consumer/ to launch socket.io on localhost:3000
POST messages to your php server where the application is installed
visit dashboard.php to view the messages as sent to the php server

For Places:

Sample URLs:
https://localhost/places/index.php?find=bananas+in+dublin
http://localhost/places/index.php?find=bananas+in+du&autocomplete

http://localhost/places/index.php?find=mangoes+in+berlin
http://localhost/places/index.php?find=mango+in+be&autocomplete

To install the code drop the places directory into your webroot /var/www/
Make sure the places directory is writable for the composer installer, use chown -R owner:owner places

The code relies on the pear package HTTP_Request2. 
To install it locally change into the places folder and use composer.
https://getcomposer.org/doc/00-intro.md#installation-nix

Use the commands
php composer.phar update 
php composer.phar install 
 
or use pear install http_request2 to install globally


Original Request:

1. Find businesses in an area.

Input:      URL GET request of search terms
Returns: name and address only as content type application/json

Given a query such as “burritos in Berlin” or “ramen in Tokyo” returns a list of establishment names and address. The response does not return additional information.


2. Address autocompletion.

Input:      URL GET request of search terms
Returns: Autocomplete address only as content type application/json

Return possible address predictions for input. Example inputs include, ‘Schlesische Strasse 27C’, ‘Paris’, or ‘Gandalf’.

Notes:

The implementation should be extensible to handle additional search methods however it is not necessary to implement them
Should be flexible enough to support xml in the future
handle connection problems to the Google Places API gracefully.
Use an object oriented approach
Do not use any existing PHP frameworks
Do not create a web form
Do not support optional Google API parameters
*Important* Please provide some sample working url calls to your service to be run on localhost in a file called README.