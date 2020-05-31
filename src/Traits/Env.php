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

/**
 * Trait Env
 *
 * Setup local environment
 */
trait Env
{

    /**
     * set current environment
     *
     * saving a value in `.server` to acknowledge the current running local stage.
     *
     * this function switches the local installation between various databases.
     * Uses `config/booka.yml` > local keys as setup for possible values.
     */
    public function env()
    {
        $this->io()->title('Set current local environment:');
        // load available environments
        $environments = array_keys(static::$setup['local']);
        // let user choose environment
        $selection = $this->io()->choice(
            'Which environment?',
            $environments,
            $environments[0]
        );
        // save .sever file
        file_put_contents('.server', $selection);
        $this->io()->success('Set current environment to: ' . $selection);
    }

}
