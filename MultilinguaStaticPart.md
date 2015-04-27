# Introduction #

According to the need, multilingua function on a web page is implemented as two part: The static (template) part and the database. This article describes how to implement multilingua in the static part.

# Details #

## Specify the language ##

The language used to display on the web pages is specified in Yii::app()->language. The are several ways to specified the language: by the user (by clicking the language specification links on the web page), by your PHP code, or the default language if specified in the application configuration file (main.php).

If your controller is a sub class of BaseController class, then the language is specified in the following priorities:
  * If the controller has the variable [$fixedLanguage](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/extensions/batsg/controllers/BaseController.php#14) specified, then it is used.
  * If $fixedLanguage is not specified, then the language specified by the user is used.
  * If the user does not specify the language, then the language specified by the configuration file (main.php) is used.
This task is implemented in [BaseController#init()](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/extensions/batsg/controllers/BaseController.php#21), which is calling in the constructor of the controller class.

## Translation methods ##

Multilingua in the static part (PHP and HTML code) is implemented by using Yii:t() method. There are convenient wrapper methods for it you may find useful: [Y::t()](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/extensions/batsg/Y.php#21) and [Y::et()](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/extensions/batsg/Y.php#21). The former returns translated message, while the later echo the translated message. There are also some other utility methods relate to multilingua implementation in the Y class.

## Managing the translation ##

There is a convenient tool (console command) to help you managing the message translation files: [i18n](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/extensions/batsg/commands/I18nCommand.php). You can create the messages and their translation in a CSV (app.csv) file, then use the i18n tool to generate the language files for you. You will find the example in [protected/messages/source](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/messages/source/). Create the app.csv file, then run the shell script generate.bat or generate.sh, and the message files are created in the folder protected/messages for you. To have the command i18n to work, put the following code to the console.php:
```php

'commandMap' => array(
'i18n' => array(
'class' => 'ext.batsg.commands.!I18nCommand',
),
),```
Please refer to [console.php](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/config/console.php#20) for the example.

## Display language links on the web page ##

[Y::languageSettingLinks()](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/extensions/batsg/Y.php#213) will display the links to select language on your web page. If you want to display images (the national flags, for example) instead of the text links, use [Y::languageSettingUrls()](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/extensions/batsg/Y.php#213) to get the URLs for changing the language. Please see the layout file [admin.php](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/views/layouts/admin.php#28) for example.