<?php

/**
 * BooKa 13
 *
 * Copyright (c) 2007-2018 - David's Neighbour Part., Ltd.
 * All rights reserved.
 *
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Moral rights are preserved. Proprietary and confidential software.
 * Written by Patrick Kollitsch <patrick@davids-neighbour.com>
 *
 * PHP Version 7.4
 *
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  All rights reserved. 2007-2018 - David's Neighbour Part., Ltd.
 * @license    license.txt
 * @package    tests
 * @since      11.7.123
 * @version    11.9.65
 * @filesource
 */

declare(strict_types=1);

/**
 * define ROOTDIR for filesystem checks, miserable hack. sorry.
 */
define('ROOTDIR', dirname(__DIR__ . '/../../../'));

/**
 * sets a marker so we can check if this is a call via API or via PHP script.
 */
if (!defined('BOOKA_API')) {
    define('BOOKA_API', true);
}
require_once ROOTDIR . '/vendor/autoload.php';
//require_once ROOTDIR . '/src/autoloader.php';
require_once ROOTDIR . '/config/config.booka.php';
require_once ROOTDIR . '/vendor/adodb/adodb-php/adodb.inc.php';
require_once ROOTDIR . '/vendor/adodb/adodb-php/adodb-active-record.inc.php';
require_once ROOTDIR . '/vendor/adodb/adodb-php/adodb-exceptions.inc.php';
require_once ROOTDIR . '/vendor/adodb/adodb-php/drivers/adodb-mysqli.inc.php';
