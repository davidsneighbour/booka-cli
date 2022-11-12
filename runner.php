#!/usr/bin/env php
<?php

/**
 * booka-cli2
 *
 * Copyright (c) 2007-2022 - David's Neighbour Part., Ltd.
 * All rights reserved.
 *
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Moral rights are preserved. Proprietary and confidential software.
 * Written by Patrick Kollitsch <patrick@davids-neighbour.com>
 *
 * PHP Version 8.1
 *
 * @category     Core
 * @package      Cli
 * @author       Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright    2007-2022 - David's Neighbour Part., Ltd.
 * @license      https://getbooka.app/license.txt proprietary
 * @version      2.0.0
 * @link         https://getbooka.app/
 * @since        2.0.0
 * @filesource
 */

// If we're running from phar load the phar autoload file.
$pharPath = \Phar::running(true);
if ($pharPath) {
    $autoloaderPath = "$pharPath/vendor/autoload.php";
} else {
    if (file_exists(__DIR__.'/vendor/autoload.php')) {
        $autoloaderPath = __DIR__.'/vendor/autoload.php';
    } elseif (file_exists(__DIR__.'/../../autoload.php')) {
        $autoloaderPath = __DIR__ . '/../../autoload.php';
    } else {
        die("Could not find autoloader. Run 'composer install'.");
    }
}
$classLoader = require_once($autoloaderPath);

// get version
$strJsonFileContents = file_get_contents("package.json");
$package = json_decode($strJsonFileContents, true);

// customization variables
$appName = "Booka CLI";
$appVersion = trim($package['version']);
$commandClasses = [ \Booka\Cli\RoboFile::class ];
$selfUpdateRepository = 'getbooka/booka-cli';
$configurationFilename = 'config.yml';

// define the runner and add classes provided
$runner = new \Robo\Runner($commandClasses);
$runner->setSelfUpdateRepository($selfUpdateRepository)
       ->setConfigurationFilename($configurationFilename)
       ->setClassLoader($classLoader);

// execute and return result
$output = new \Symfony\Component\Console\Output\ConsoleOutput();
$statusCode = $runner->execute($argv, $appName, $appVersion, $output);
exit($statusCode);
