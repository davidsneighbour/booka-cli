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

use Booka\Cli\Traits\Database;
use Booka\Cli\Traits\Development;
use Booka\Cli\Traits\Documentation;
use Booka\Cli\Traits\Env;
use Booka\Cli\Traits\QualityInsurance;
use Booka\Cli\Traits\Stage;
use Booka\Cli\Traits\Testing;
use Robo\Tasks;
use Symfony\Component\Yaml\Yaml;

/**
 * Class RoboFile
 *
 * RoboFile stub to be used with all task classes. Loads setup and adds re-used methods.
 */
class RoboFile extends Tasks
{
    use Database;
    use Development;
    use Documentation;
    use Env;
    use QualityInsurance;
    use Stage;
    use Testing;

    /**
     * @param string $rootdir directory in which the robo command is run
     */
    protected static string $rootdir = './';

    /**
     * @param mixed $setup
     */
    protected static array $setup;

    /**
     * @param string $apidir API directory of Booka
     */
    protected static string $apidir = 'src/';

    public function __construct()
    {
        static::$setup = Yaml::parseFile(static::$rootdir . '/config/booka.yml');
    }

}
