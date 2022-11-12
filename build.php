<?php

/** @noinspection PhpUndefinedMethodInspection */

/**
 * BooKa 13 CLI
 *
 * Copyright (c) 2007-2019 - David's Neighbour Part., Ltd.
 * All rights reserved.
 *
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Moral rights are preserved. Proprietary and confidential software.
 * Written by Patrick Kollitsch <patrick@davids-neighbour.com>
 *
 * PHP Version 8.1
 *
 * @category   CLI
 * @package    CLI
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2019 - David's Neighbour Part., Ltd.
 * @license    https://inkohsamui.com/license.txt proprietary
 * @version    NEW
 * @link       https://inkohsamui.com/
 * @since      NEW
 * @filesource
 */

declare(strict_types=1);

$exclude = [
    '.git',
    '.github',
    '.idea',
    'dist',
    'node_modules',
    'tmp',
    '.cz-config.js',
    '.editorconfig',
    '.gitignore',
    'booka.yml.sample',
    'build.php',
    'churn.yml',
    'composer.json',
    'composer.lock',
    'package.json',
    'package-lock.json',
    'phpstan.neon',
    'psalm.xml',
    'README.md',
    'Robofile.php',
];

/**
 * @param $file
 * @param $key
 * @param $iterator
 * @return bool
 */
/** @noinspection PhpUnusedParameterInspection */
$filter = function (
    $file,
    $key, // NOSONAR
    $iterator
) use ($exclude) {
    if ($iterator->hasChildren() && !in_array($file->getFilename(), $exclude, true)) {
        return true;
    }
    return $file->isFile() && !in_array($file->getFilename(), $exclude, true);
};
$iterator = new RecursiveIteratorIterator(
    new RecursiveCallbackFilterIterator(
        new RecursiveDirectoryIterator(__DIR__, RecursiveDirectoryIterator::SKIP_DOTS),
        $filter
    )
);
$phar = new Phar("booka-cli.phar");
$phar->setSignatureAlgorithm(Phar::SHA1);
$phar->startBuffering();
$phar->buildFromIterator($iterator, __DIR__);
//default executable
$phar->setStub("#!/usr/bin/php \n" . $phar::createDefaultStub('init.php'));
$phar->stopBuffering();
