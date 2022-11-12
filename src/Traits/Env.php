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
	 *
	 * @psalm-suppress PossiblyUnusedMethod
	 */
	public function env(): void
	{
		$this->io()->title('Set current local environment:');
		// load available environments
		/**
		 * @psalm-suppress PossiblyNullArgument
		 * @psalm-suppress PossiblyNullArrayAccess
		 */
		$environments = array_keys(static::$setup['local']);
		// let user choose environment
		$selection = $this->io()->choice(
			'Which environment?',
			$environments,
			$environments[0]
		);
		// save .sever file
		file_put_contents('.dotfiles/.server', $selection);
		$this->io()->success('Set current environment to: ' . $selection);
	}
}
