Metin2CMS
=========
[![N|Solid](http://i.imgur.com/dS8151Q.png)](https://metin2cms.cf/v2)

[![Github All Releases](https://img.shields.io/github/downloads/IonutPopescuRO/Metin2CMS/total.svg)]()
[![GitHub release](https://img.shields.io/github/release/IonutPopescuRO/Metin2CMS.svg?color=%23f17e3f)]()
[![License](https://img.shields.io/github/license/IonutPopescuRO/Metin2CMS.svg?color=%230d7ebf)]()

The latest version of the CMS. This CMS is Open-Source and is accompanied by updates. To update to a newer version, enter in administrator panel.


REQUIREMENTS
------------

The minimum requirement by Metin2CMS that your Web server supports PHP 5.6.0.

MySQL CONNECTION
------------

Communication with the database of the cms is done using the PDO extension. Settings are saved in json files. 

LANGUAGES
------------
The platform is available in 11 languages:

  - [en]	English 	
  - [ro] 	Română 	
  - [fr] 	Français 	
  - [pl] 	Polski 	
  - [pt-BR] 	Português (BR) 	
  - [es] 	Español 	
  - [it] 	Italiano
  - [tr] 	Türk
  - [hu] 	Magyar 	
  - [de] 	Deutsch
  - [el] 	Ελληνικά
  
If you want to help, you can translate in your language and send us.

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

	//Mail settings
	$SMTPAuth = true;
	$SMTPSecure = "ssl";
	$EmailHost = "smtp.gmail.com";
	$emailPort = 465;
	
	$email_username = "metin2cms.cf@gmail.com";//gmail account
	$email_password = "xxxxxx";//gmail password
	
	//Register
	$safebox_size = 1;
```

### Preview
<details><summary>CLICK ME</summary>
<p>
	<img src="https://i.imgur.com/EAR2Jc1.png"></img>
	<img src="https://i.imgur.com/PMnWEUy.png"></img>
	<img src="https://i.imgur.com/y4ivCJu.png"></img>
	<img src="https://i.imgur.com/GZgQ2tR.png"></img>
	<img src="https://i.imgur.com/1rRl1a5.png"></img>
	<img src="https://i.imgur.com/4884Z6K.png"></img>
	<img src="https://i.imgur.com/PC7CL34.png"></img>
	<img src="https://i.imgur.com/YSoe3CM.png"></img>
	<img src="https://i.imgur.com/J3zrrYK.png"></img>
</p>
</details>
