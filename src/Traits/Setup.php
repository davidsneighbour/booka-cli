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

use Safe\Exceptions\FilesystemException;

use function Safe\file_put_contents;

/**
 * Trait Setup
 */
trait Setup
{

	/**
	 * Helper function to setup local sentry configuration (used for relase
	 * updates)
	 *
	 * @return void
	 *
	 * @psalm-suppress PossiblyUnusedMethod
	 */
	public function sentrysetup(): void
	{
		$this->io()->title('Setup .sentryclirc file');
		$organization = $this->io()->ask('Name of your organization:');
		$projectslug = $this->io()->ask('Slug of your project:');
		$this->io()->note(
			'You find this information on https://sentry.io/settings/account/api/auth-tokens/.' .
				"\n" . 'Create an API key with permissions for `project:releases`.'
		);
		$token = $this->io()->ask('API token');

		$output = "[defaults]\n";
		$output .= "org=" . $organization . "\n";
		$output .= "project=" . $projectslug . "\n\n";
		$output .= "[auth]\n";
		$output .= "token=" . $token . "\n";

		/** @noinspection PhpUndefinedFieldInspection */
		$filename = static::$rootdir . '/.sentryclirc';

		try {
			file_put_contents($filename, $output);
			$this->io()->success('Configuration file .sentryclirc written.');
		} catch (FilesystemException $eException) {
			$this->io()->error('Could not write to file .sentryclirc.');
		}
	}

	// curl -sL https://sentry.io/get-cli/ | bash
	// ./node_modules/.bin/sentry-cli login
	// sentry-cli info
	// eval "$(sentry-cli bash-hook)" to enable bash error tracking
}
