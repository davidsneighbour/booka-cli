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
 * @package    tests
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  All rights reserved. 2007-2018 - David's Neighbour Part., Ltd.
 * @license    license.txt
 * @version    11.9.65
 * @since      11.7.123
 * @filesource
 */

declare(strict_types=1);

// https://codeception.com/docs/modules/REST
/**
 * sets a marker so we can check if this is a call via API or via PHP script.
 */
if (!defined('BOOKA_API')) {
    define('BOOKA_API', true);
}
