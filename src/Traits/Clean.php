<?php

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
 * PHP Version 7.4
 *
 * @category   Cli
 * @package    Cli
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2019 - David's Neighbour Part., Ltd.
 * @license    https://getbooka.app/license.txt proprietary
 * @version    NEW
 * @link       https://getbooka.app/
 * @since      NEW
 * @filesource
 */

declare(strict_types=1);

namespace Booka\Cli\Traits;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Plugin\ListPaths;

/**
 * Trait Clean
 */
trait Clean
{

    /**
     * Clean caches and (with --full parameter) packages/libraries
     *
     * @param array $opts
     */
    public function clean(array $opts = ['full|f' => false]): void
    {
        $this->cleanTemps();

        if (is_array($opts) && isset($opts['full'])) {
            foreach (
                [
                    static::$rootdir . '/public/javascripts/node_modules',
                    static::$rootdir . '/vendor',
                    static::$rootdir . '/node_modules',
                ] as $sDirectory
            ) {
                if (file_exists($sDirectory)) {
                    $this->taskCleanDir($sDirectory)->run();
                }
            }
        }
    }

    private function cleanTemps()
    {
        $this->cleanCache();
        foreach (
            [
                static::$rootdir . '/tmp',
                static::$rootdir . '/tests/_output',
                static::$rootdir . '/public/api5/documentation',
            ] as $sDirectory
        ) {
            if (file_exists($sDirectory)) {
                $this->taskCleanDir($sDirectory)->run();
            }
        }

        $this->writeGitignore(static::$rootdir . '/tests/_output/.gitignore');
    }

    private function cleanCache(): void
    {
        // setting up file system
        $adapter = new Local('/');
        $filesystem = new Filesystem($adapter);
        $filesystem->addPlugin(new ListPaths());

        $dirs = $filesystem->listPaths(static::$rootdir . '/cache/');

        foreach ($dirs as $dir) {
            $sDir = '/' . $dir;
            if (!is_file($sDir)) {
                foreach (
                    [
                        $sDir . '/smarty/templates_c/',
                        $sDir . '/smarty/cache/',
                    ] as $sDirectory
                ) {
                    if (file_exists($sDirectory)) {
                        $this->taskCleanDir($sDirectory)->run();
                    }
                }
            }
        }
        $sApiCache = static::$rootdir . '/public/api5/cache/';
        if (file_exists($sApiCache)) {
            $this->taskCleanDir($sApiCache)->run();
        }

        $this->writeGitignore(static::$rootdir . '/public/api5/cache/.gitignore');
    }

    /**
     * @param string $filename
     */
    private function writeGitignore(string $filename): void
    {
        $this->taskWriteToFile($filename)
            ->line('*')
            ->line('!.gitignore')
            ->run();
    }

    /**
     * cleanup temporary directories and build files
     */
    public function cleanup()
    {
        $this->cleanTemps();
    }

}
