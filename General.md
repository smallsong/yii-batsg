# Introduction #

This document contains the introduction about the library **yii-batsg** and the sample code.

# Details #

**yii-batsg** is an extension for **yii framework**. It contains serveral classes (for utility function and some work flow) that I usually use.

The project **yii-batsg** is a application based on **yii framework**. It contains the yii-batsg extension code (placed in protected/extensions/batsg) and the demonstration code (the application itself). You can find the usage of the extension classes in the demonstration code and in the unit testing code.

What you may find useful:
  * How to import some value in config/main.php to config/console.php: see [console.php](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/config/console.php)
  * How to imlement a simple data management workflow (index/create/update/confirm/view/delete) using [SimpleBaseController](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/extensions/batsg/controllers/SimpleBaseController.php): see [CompanyController.php](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/controllers/admin/CompanyController.php) for the example.
  * How to implement multilinguaga web pages: see MultilinguaStaticPart
  * How to use [Y](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/extensions/batsg/Y.php) class: see [YTest.php](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/tests/unit/batsg/YTest.php)
  * How to use [HDateTime](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/extensions/batsg/HDateTime.php) class: see [HDateTimeTest.php](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/tests/unit/batsg/HDateTimeTest.php)
  * How to use [HExcel](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/extensions/batsg/HExcel.php) class: see [HExcelTest.php](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/tests/unit/batsg/HDateTimeTest.php)
  * How to use [HJapanese](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/extensions/batsg/HJapanese.php) class: see [HJapaneseTest.php](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/tests/unit/batsg/HJapaneseTest.php)
  * How to use [HRandom](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/extensions/batsg/HRandom.php) class: see [HRandomTest.php](http://code.google.com/p/yii-batsg/source/browse/trunk/yii-batsg/protected/tests/unit/batsg/HRandomTest.php)