# Introduction #

This page introduce how to set up yii-batsg to use batsg in a project.

# Details #

## Setup ##

Download and unzip batsg into the folder `protected/extensions`.

Edit protected/config/main.php to import batsg
```
    // autoloading model and component classes
    'import' => array(
        // ...
        'ext.batsg.*',
    ),
```

mb\_internal\_encoding("UTF-8");