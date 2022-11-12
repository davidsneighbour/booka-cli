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

}
