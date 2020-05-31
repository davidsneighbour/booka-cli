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

use Robo\Contract\VerbosityThresholdInterface;

/**
 * Trait Documentation
 */
trait Documentation
{

    /**
     * analyse code and create API documentation
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
            ->process('./vendor/bin/testability ' . static::$apidir . ' -o public/api5/documentation/testability')
            ->process('./vendor/bin/phpmetrics --report-html=public/api5/documentation/metrics  ' . static::$apidir)
            ->run();

        $this->createDirectoryIndex();
        $this->taskExecStack()
            ->setVerbosityThreshold(
                VerbosityThresholdInterface::VERBOSITY_DEBUG
            )
            ->stopOnFail()
            ->exec('git checkout -- public/api5/documentation/index.html');
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
            ->coverageHTML('./public/api5/documentation/coverage/');

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
                . './public/api5/documentation/apidoc/.htaccess'
            )
            ->process(
                'echo "DirectoryIndex index.html" > '
                . './public/api5/documentation/testability/.htaccess'
            )
            ->process(
                'echo "DirectoryIndex index.html" > '
                . './public/api5/documentation/metrics/.htaccess'
            )
            ->process(
                $this->taskExec(
                    'echo "DirectoryIndex index.html" > '
                    . './public/api5/documentation/.htaccess'
                )
            )
            ->run();
    }

}
