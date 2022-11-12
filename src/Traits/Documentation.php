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

declare (strict_types = 1);

namespace Booka\Cli\Traits;

use Robo\Contract\VerbosityThresholdInterface;

/**
 * Trait Documentation
 */
trait Documentation
{

    /**
     * analyse code and create API documentation
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function documentation(): void
    {
        $this->prepare();

        // run smaller tasks in parallel
        $this->say('Create Documentation Content');
        $this->taskParallelExec()
            ->setVerbosityThreshold(
                VerbosityThresholdInterface::VERBOSITY_DEBUG
            )
            ->process('./vendor/bin/codecept run unit --coverage --coverage-html')
            ->process('./vendor/bin/phpdox -f config/phpdox.xml.dist')
            ->process('./vendor/bin/testability ' . static::$apidir . ' -o documentation/testability/')
            ->process('./vendor/bin/phpmetrics --report-html=documentation/metrics/  ' . static::$apidir)
            ->run();

        $this->_exec('cp -R tests/_output/coverage documentation/');

        $this->_exec('php -S localhost:8000 -t documentation/ &');
        $this->_exec('chromium-browser http://localhost:8000 &');

        $this->createDirectoryIndex();
    }

    /**
     * prepare measurement files (codecoverage, phploc and so on) used for
     * PhpDox later on.
     */
    private function prepare(): void
    {
        // unit tests to create code coverage xml file
        $this->say('Setup Code Coverage');
        $coverage = $this->taskCodecept()
            ->suite('unit')
            ->option('--fail-fast')
            ->coverageXml()
            ->coverageHTML('./documentation/coverage/');

        // prepare stuff
        $this->taskExecStack()
            ->setVerbosityThreshold(
                VerbosityThresholdInterface::VERBOSITY_DEBUG
            )
            ->stopOnFail()
            ->exec('mkdir -p tmp')
            ->exec('cp ./tests/_output/coverage.xml tmp/index.xml')
            ->exec('./vendor/bin/phpcs --config-set ignore_errors_on_exit 1')
            ->run();

        // run smaller tasks in parallel
        $this->say('Create Configuration Files');
        $this->taskParallelExec()
            ->setVerbosityThreshold(
                VerbosityThresholdInterface::VERBOSITY_DEBUG
            )
            ->process(
                './vendor/bin/phploc  ' . static::$apidir . '  --quiet --count-tests '
                . '--log-xml tmp/phploc.xml'
            )
            ->process(
                './vendor/bin/phpcs -q --runtime-set ignore_warnings_on_exit --cache '
                . '--report=xml > tmp/phpcs.xml'
            )
            ->process(
                './vendor/bin/phpmd ' . static::$apidir . ' xml cleancode,codesize,controversial,'
                . 'design,naming,unusedcode --reportfile tmp/phpmd.xml '
                . '--ignore-violations-on-exit'
            )
            ->process($coverage)
            ->run();
    }

    /**
     * creates a htaccess file that serves index.html als index file
     */
    private function createDirectoryIndex(): void
    {
        $this->say('Fixing Directory Indexes');
        $this->taskParallelExec()
            ->setVerbosityThreshold(
                VerbosityThresholdInterface::VERBOSITY_DEBUG
            )
            ->process(
                'echo "DirectoryIndex index.html" > '
                . './documentation/apidoc/.htaccess'
            )
            ->process(
                'echo "DirectoryIndex index.html" > '
                . './documentation/testability/.htaccess'
            )
            ->process(
                'echo "DirectoryIndex index.html" > '
                . './documentation/coverage/.htaccess'
            )
            ->process(
                'echo "DirectoryIndex index.html" > '
                . './documentation/metrics/.htaccess'
            )
            ->process(
                $this->taskExec(
                    'echo "DirectoryIndex index.html" > '
                    . './documentation/.htaccess'
                )
            )
            ->run();
    }

    public function documentationDown(): void
    {
        $this->_exec('killall -9 php');
    }
}
