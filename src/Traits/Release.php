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
use Robo\Contract\VerbosityThresholdInterface;
use Safe\Exceptions\FilesystemException;

use function Safe\file_get_contents;

/**
 * Trait Release
 */
trait Release
{

    /**
     * Release a minor version
     *
     * @param array $opts
     *
     * @option string $what update target (major, minor or patch)
     */
    public function release(array $opts = ['what|w' => 'patch']): void
    {
        /**
         * 1. check if we are on the master branch
         * 2. run `git pull`
         * 3. check if git is porcellaine
         * 4. run tests
         * 5. increase version number
         * 6. build release files
         * 7. update version numbers in submodules
         * 8. push codebase
         * 9. notify sentry.io
         */

        // check if we are on branch master
        if (!$this->isMasterBranchUsed()) {
            $this->io()->error('We are NOT on the master branch. ');
            exit; // NOSONAR
        } // NOSONAR

        // testing
        $this->test();

        // create versioning update
        $aOldVersion = $this->getVersionArray();
        $sOldVersion = $this->getVersion($aOldVersion);
        $aNewVersion = $this->increaseVersionArray($aOldVersion, $opts['what']);
        $sNewVersion = $this->getVersion($aNewVersion);

        // replace versioning numbers in files
        $this->taskReplaceInFile(static::$rootdir . '/composer.json')
            ->from($sOldVersion)->to($sNewVersion)
            ->run();
        $this->taskReplaceInFile(static::$rootdir . '/LICENSE.md')
            ->from($sOldVersion)->to($sNewVersion)
            ->run();
        $this->taskReplaceInFile(static::$rootdir . '/package.json')
            ->from($sOldVersion)->to($sNewVersion)
            ->run();

        //$this->versioning();

        $this->buildChangelog();
        $this->wpCompile();
        $this->deployApiDocumentation();

        // update submodules
        $this->updateSubmodule('config');
        $this->updateSubmodule('plugins');

        // create version number file
        $aVersion = $this->getVersionArray();
        $this->saveVersion($aVersion);

        // push codebase
        $this->pushCodebase();

        // notify sentry.io of new version
        $this->taskNotifySentry();
    }

    /**
     *
     */
    private function isMasterBranchUsed(): bool
    {
        $branch = exec('git rev-parse --abbrev-ref HEAD');

        return ($branch === 'master');
    }

    /**
     * @return array
     */
    protected function getVersionArray()
    {
        try {
            $sVersion = file_get_contents(static::$rootdir . '/.version');
        } catch (FilesystemException $eException) {
            return [];
        }
        $aVersion = explode('.', $sVersion);
        foreach ($aVersion as $key => $value) {
            $aVersion[$key] = intval($value);
        }
        unset($aVersion[4]);

        return $aVersion;
    }

    /**
     * @param array $version
     *
     * @return string
     */
    protected function getVersion(array $version): string
    {
        $sVersion = implode('.', $version);

        return $sVersion;
    }

    /**
     * @param array  $version
     * @param string $what
     *
     * @return array
     */
    protected function increaseVersionArray(array $version, string $what = 'patch'): array
    {
        switch ($what) {
            case 'major':
                $version[0] += 1;
                $version[1] = 0;
                $version[2] = 0;
                break;

            case 'minor':
                $version[1] += 1;
                $version[2] = 0;
                break;

            case 'patch':
            default:
                $version[2] += 1;
                break;
        }

        $this->saveVersion($version);

        return $version;
    }

    /**
     * @param array $version
     */
    protected function saveVersion(array $version): void
    {
        $sVersion = $this->getVersion($version);
        $this->taskWriteToFile(static::$rootdir . '/.version')
            ->line($sVersion)
            ->run();
    }

    private function buildChangelog(): void
    {
        $this->taskParallelExec()
            ->process('npm run build-changelog')
            ->run();
    }

    private function deployApiDocumentation()
    {
        $this->taskExec('./bin/deploy-api-doc.sh')
            ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
            ->run();
    }

    /**
     * @param string $type
     */
    protected function updateSubmodule($type = 'config'): void
    {
        switch ($type) {
            case 'plugins':
                $sDirectory = static::$rootdir . '/plugins';
                break;

            case 'config':
            default:
                $sDirectory = static::$rootdir . '/config';
                break;
        }

        $this->taskGitStack()
            ->dir($sDirectory)
            ->stopOnFail()
            ->add('-A')
            ->commit(sprintf('chore: update %s version numbers', $type))
            ->push('origin', 'master')
            ->run();
    }

    protected function pushCodebase(): void
    {
        $aVersion = $this->getVersionArray();
        $sVersion = $this->getVersion($aVersion);

        /**
         * move everything to GitHub
         */
        $this->taskGitStack()
            ->stopOnFail()
            ->add('-A')
            ->commit('chore(git): release ' . $sVersion)
            ->tag($sVersion)
            ->push('origin', '--tags')
            ->push('origin', '--all')
            ->run();
    }

    /**
     * Create versioning tags in PHPDoc for new classes/methods/files
     *
     * @see https://www.phpliveregex.com/ for playground to check regex
     */
    private function versioning(string $what = 'patch'): void
    {
        // rootpath
        $rootpath = static::$rootdir;

        // paths to check
        $aCheckedPaths = static::$setup['versioning']['checkedPaths'] ?? [];
        $aCheckedFiles = static::$setup['versioning']['checkedFiles'] ?? [];
        $aIgnoredPaths = static::$setup['versioning']['ignoredPaths'] ?? [];

        // search and replace strings
        $sVersionNewTag = ' * @version    NEW';
        $sVersionReplace = ' * @version    ';
        $sVersionReplace2 = '/\s\*\s@version\s*\d*\.\d*\.\d*/i';
        $sSinceNewTag = ' * @since      NEW';
        $sSinceReplace = ' * @since      ';

        // retrieve config paths
        $adapter = new Local($rootpath);
        $filesystem = new Filesystem($adapter);
        $filesystem->addPlugin(new ListPaths());

        // retrieve version number
        try {
            $sVersion = trim(file_get_contents(static::$rootdir . '/.version'));
        } catch (FilesystemException $eException) {
            $sVersion = 'unknown';
        }

        foreach ($aCheckedPaths as $item) {
            $paths = $filesystem->listPaths($item, true);

            // iterate through paths
            $this->say('replacing new versioning tags');
            foreach ($paths as $path) {
                if (!is_dir($path) && !in_array($path, $aIgnoredPaths, true)) {
                    $this->replaceVersion($path, $sVersionNewTag, $sVersionReplace . $sVersion);
                    $this->replaceVersion($path, $sSinceNewTag, $sSinceReplace . $sVersion);
                    if ($what !== 'patch') {
                        $this->replaceVersionRegexp(
                            $path,
                            $sVersionReplace2,
                            $sVersionReplace . $sVersion
                        );
                    }
                }
            }
        }

        foreach ($aCheckedFiles as $file) {
            $this->replaceVersion($file, $sVersionNewTag, $sVersionReplace . $sVersion);
            $this->replaceVersion($file, $sSinceNewTag, $sSinceReplace . $sVersion);

            if ($what !== 'patch') {
                $this->replaceVersionRegexp(
                    $file,
                    $sVersionReplace2,
                    $sVersionReplace . $sVersion
                );
            }
        }
    }

    /**
     * Replaces old content to new content in a file
     *
     * @param string $path to the file to be replaced within
     * @param string $old  text to be replaced
     * @param string $new  text to be replaced
     */
    private function replaceVersion(string $path, string $old, string $new): void
    {
        $this->taskReplaceInFile(static::$rootdir . '/' . $path)
            ->setVerbosityThreshold(
                VerbosityThresholdInterface::VERBOSITY_DEBUG
            )
            ->from($old)
            ->to($new)
            ->run();
    }

    /**
     * Replaces old content to new content in a file
     *
     * @param string $path to the file to be replaced within
     * @param string $old  text to be replaced
     * @param string $new  text to be replaced
     */
    private function replaceVersionRegexp(string $path, string $old, string $new): void
    {
        $this->taskReplaceInFile(static::$rootdir . '/' . $path)
            ->setVerbosityThreshold(
                VerbosityThresholdInterface::VERBOSITY_DEBUG
            )
            ->regex($old)
            ->to($new)
            ->run();
    }


//    private function taskNotifySentry(): void
//    { // NOSONAR
//        if (file_exists(static::$rootdir . '/.sentryclirc')) {// NOSONAR
//            $this->taskExecStack()
//                ->stopOnFail()
//                ->exec(
//                    'VERSION=`cat .version` &&
//                    ./node_modules/.bin/sentry-cli releases new $VERSION &&
//                    ./node_modules/.bin/sentry-cli releases set-commits --auto $VERSION'
//                )
//                ->run();// NOSONAR
//            return;// NOSONAR
//        }// NOSONAR
//        $this->io->note('Run "./booka setup:sentry" to add relases to Sentry.');// NOSONAR
//    }// NOSONAR

}
