<?php

$autoloads = array(
    __DIR__.'/../vendor/autoload.php'
);

$autoloadFile = false;

foreach ($autoloads as $file) {
    if (!$autoloadFile && is_file($file)) {
        $autoloadFile = $file;
    }
}

if (!$autoloadFile) {
    die('Unable to find autoload.php file, please use composer to load dependencies:

wget http://getcomposer.org/composer.phar
php composer.phar install

Visit http://getcomposer.org/ for more information.

');

}

include $autoloadFile;

// Check for symfony 2.7 or higher and disable deprecated errors if found
if (file_exists($file = __DIR__ . '/../vendor/composer/installed.json')) {
    $installedPackages = json_decode(file_get_contents($file), true);
    foreach ($installedPackages as $installedPackage) {
        if (
            strpos($installedPackage['name'], 'symfony/') !== 0 ||
            version_compare($installedPackage['version_normalized'], '2.7', '<')
        ) {
            continue;
        }

        \PHPUnit_Framework_Error_Deprecated::$enabled = false;
        break;
    }
    unset($installedPackages);
}