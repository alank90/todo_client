For PHP error - Call to undefined function mcrypt_encrypt()
Do following :
$ sudo mv /etc/php5/conf.d/mcrypt.ini /etc/php5/mods-available/
$ sudo php5enmod mcrypt
$ sudo service apache2 restart
Note: Only had to do last two commands to clear error messsage


For PHP error - Fatal error: Call to undefined function curl_init()
First try installing curl on server:
sudo apt-get install curl libcurl3 libcurl3-dev php5-curl
and then restart apache
sudo service apache2 restart
If that doesn't work try:
Go to your php.ini file and remove the ; mark from the beginning of the following line:
;extension=php_curl.dll


For error Fatal error: Cannot use object of type stdClass as array 
Use the second parameter of json_decode to make it return an array:
$result = @json_decode($result, true);


