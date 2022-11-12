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

declare(strict_types=1);

use Booka\Cli\RoboFile as CliRoboFile;

define('ROOTDIR', dirname(__FILE__));

/**
 * Class RoboFile
 *
 * RoboFile stub to be used with all task classes. Loads setup and adds re-used methods.
 */
class RoboFile extends CliRoboFile
{

    public function __construct()
    {

        // set root directory
        static::$rootdir = dirname(__FILE__);
        parent::__construct();
    }

}
