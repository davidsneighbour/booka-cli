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

namespace Booka\Cli;

require_once 'vendor/autoload.php';
require_once 'src/autoloader.php';

use Booka\Cli\Traits\Build;
use Booka\Cli\Traits\Clean;
use Booka\Cli\Traits\Database;
use Booka\Cli\Traits\Development;
use Booka\Cli\Traits\Documentation;
use Booka\Cli\Traits\Env;
use Booka\Cli\Traits\Maintenance;
use Booka\Cli\Traits\QualityInsurance;
use Booka\Cli\Traits\Release;
use Booka\Cli\Traits\Setup;
use Booka\Cli\Traits\Stage;
use Booka\Cli\Traits\Testing;
use Booka\Cli\Traits\Wordpress;
use Curl\Curl;
use function Safe\file_get_contents;use function Safe\json_encode;
use Robo\Contract\VerbosityThresholdInterface;

use Robo\ResultData;

use Robo\Tasks;
use RuntimeException;
use Safe\Exceptions\JsonException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class RoboFile
 *
 * RoboFile stub to be used with all task classes. Loads setup and adds re-used methods.
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class RoboFile extends Tasks
{
    use Build;
    use Clean;
    use Database;
    use Development;
    use Documentation;
    use Env;
    use Maintenance;
    use QualityInsurance;
    use Release;
    use Setup;
    use Stage;
    use Testing;
    use Wordpress;

    /**
     * @var string $rootdir directory in which the robo command is run
     */
    protected static string $rootdir = './';

    /**
     * @var array<array-key, mixed>
     */
    protected static ?array $setup;

    /**
     * @var string API directory of Booka
     */
    protected static string $apidir = 'src/';

    /**
     * RoboFile constructor.
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function __construct()
    {
        // grabbing configuration from booka.yml file in the config directory
		
        static::$setup = Yaml::parseFile(static::$rootdir . '/config/booka.yml');
    }

    public function taskNotifySentry() : void
    {

        $this->stopOnFail(true);

        // check if sentry is installed
        $this->checkSentry();

        // current booka version
        $sVersion = 'VERSION=`cat .version` && ';

        // environmental variables for sentry
        // set up via config/booka.yml
        $sEnvironventVars = 'export SENTRY_ORG=' . static::$setup['sentry']['org'] . ' && ';
        $sEnvironventVars .= 'export SENTRY_PROJECT=' . static::$setup['sentry']['project'] . ' && ';
        $sEnvironventVars .= 'export SENTRY_DSN=' . static::$setup['sentry']['dsn'] . ' && ';
        $sEnvironventVars .= 'export SENTRY_AUTH_TOKEN=' . static::$setup['sentry']['token'] . ' && ';

        // send release info
        $sReleaseInfo = './node_modules/.bin/sentry-cli releases new "$VERSION" && ';
        $sReleaseInfo .= './node_modules/.bin/sentry-cli releases finalize "$VERSION" && ';

        // send commit info
        $sCommitInfo = './node_modules/.bin/sentry-cli releases set-commits --auto $VERSION';

        $this->io()->note('Update sentry.io');
        $this->taskExecStack()
            ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
            ->exec(
                $sVersion .
                $sEnvironventVars .
                $sReleaseInfo .
                $sCommitInfo
            )
            ->run();
        $this->io()->note('Update sentry.io - done');

    }

    /**
     * @return ResultData|null
     */
    protected function checkSentry()
    {
        $filename = static::$rootdir . '/node_modules/.bin/sentry-cli';

        if (!file_exists($filename)) {
            $this->io()->error('sentry-cli is not installed. Run `npm install`.');

            return new ResultData(-1);
        }
    }

    /**
     * Notify sentry.io of release deploy to a certain deployment stage
     *
     * @param array $remote
     *
     */
    protected function sentryDeployNotification(array $remote): void
    {
        // @todo check if sentry-cli is set up properly and warn if not
        // @todo add duration of staging

        //        start=$(date +%s)
        //...
        //now=$(date +%s)
        //sentry-cli releases deploys VERSION new -e ENVIRONMENT -t $((now-start))

        // script to retrieve the latest tagged version per semver rules
        $sSentryCommand = sprintf(
            './node_modules/.bin/sentry-cli releases deploys %s new -e %s',
            exec('git tag | sort -r --version-sort | head -n1'),
            $remote['servername']
        );

        // notify sentry.io of new deploy
        $this->taskExecStack()
            ->stopOnFail()->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
            ->exec($sSentryCommand)->run();
    }

    /**
     * @param array  $extra
     * @param string $message
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    protected function sentrySendEvent(string $message, array $extra = []): void
    {
        $sEnvironventVars = 'export SENTRY_DSN=' . static::$setup['sentry']['dsn'] . ' && ';
        $sMessage = './node_modules/.bin/sentry-cli send-event -m "' . $message . '"';

        $sExtra = '';
        if (count($extra) > 0) {
            foreach ($extra as $key => $value) {
                $sExtra .= ' -e ' . strval($key) . ':' . $value . ' ';
            }
        }

        $sRelease = ' --release ';

        $this->taskExecStack()
            ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
            ->exec(
                $sEnvironventVars .
                $sMessage .
                $sExtra .
                $sRelease
            )
            ->run();

        return;
    }
}
