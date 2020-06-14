<?php

/**
 * BooKa 13
 *
 * Copyright (c) 2007-2020 - David's Neighbour Part., Ltd.
 * All rights reserved.
 *
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Moral rights are preserved. Proprietary and confidential software.
 * Written by Patrick Kollitsch <patrick@davids-neighbour.com>
 *
 * PHP Version 7.4
 *
 * @category   Tests
 * @package    Tests
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2020 - David's Neighbour Part., Ltd.
 * @license    https://inkohsamui.com/license.txt proprietary
 * @version    11.9.85
 * @link       https://inkohsamui.com/
 * @since      11.9.85
 * @filesource
 */

declare(strict_types=1);

/**
 * bootstrap file that loads some non-autoloader compatible classes and
 * prepares stuff that lead to errors in PhpStan-runs
 */
$sPath = dirname(__FILE__);
require_once $sPath . '/../vendor/adodb/adodb-php/adodb.inc.php';
require_once $sPath . '/../vendor/adodb/adodb-php/adodb-exceptions.inc.php';
require_once $sPath . '/../vendor/adodb/adodb-php/drivers/adodb-mysqli.inc.php';
