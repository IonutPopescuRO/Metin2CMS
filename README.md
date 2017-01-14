Metin2CMS
=========
[![N|Solid](http://i.imgur.com/dS8151Q.png)](https://metin2cms.cf/v2)

The latest version of the CMS. This CMS is Open-Source and is accompanied by updates. To update to a newer version, enter in administrator panel.


REQUIREMENTS
------------

The minimum requirement by Metin2CMS that your Web server supports PHP 5.6.0.

Communication with the database of the cms is done using the PDO extension. Settings are saved in json files. The platform is available in 2 languages:

  - English
  - Română

INSTALATION
------------

**All you have to do now is to edit the file `config.php`.**

```sh
	//Game database
	$host = "localhost";
	$user = "root";
	$password = "xxxxxx";
	
	//Site url - add / at the end, eg: http://metin2cms.cf/mt2/
	$site_url = "http://metin2cms.cf/mt2/";
	
	//Privileges - web_admin minim level for use admin functions
	$news_lvl = 1;
	
	//Mail settings
	$SMTPAuth = true;
	$SMTPSecure = "tls";
	$EmailHost = "smtp.gmail.com";
	$emailPort = 587;
	
	$email_username = "metin2cms.cf@gmail.com";//gmail account
	$email_password = "xxxxxx";//gmail password
	
	//Register
	$safebox_size = 1;
```

### Preview
![screenshot](https://i.imgur.com/PMnWEUy.png)
![screenshot](https://i.imgur.com/y4ivCJu.png)
![screenshot](https://i.imgur.com/GZgQ2tR.png)
![screenshot](https://i.imgur.com/1rRl1a5.png)
![screenshot](https://i.imgur.com/4884Z6K.png)
![screenshot](https://i.imgur.com/PC7CL34.png)
![screenshot](https://i.imgur.com/YSoe3CM.png)
![screenshot](https://i.imgur.com/J3zrrYK.png)
