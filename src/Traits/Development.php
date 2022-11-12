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

use Robo\Contract\VerbosityThresholdInterface;

/**
 * Trait Development
 *
 * Create and maintain development environment
 */
trait Development
{

	/**
	 * @psalm-suppress PossiblyUnusedMethod
	 */
	public function devPrepare(): void
	{
		// remove logfiles
		// remove documentation
		// check environment and tell current status

		// pull recent changes from repository
		$this->say('Pulling repository changes');
		$this->taskExecStack()
			->setVerbosityThreshold(
				VerbosityThresholdInterface::VERBOSITY_DEBUG
			)
			->stopOnFail()
			->exec('git pull origin')
			->run();

		// remove node and composer packages
		$this->say('Cleaning up composer and node packages');
		$this->taskExecStack()
			->setVerbosityThreshold(
				VerbosityThresholdInterface::VERBOSITY_DEBUG
			)
			->stopOnFail()
			->exec('rm -rf node_modules')
			->exec('rm -f package-lock.json')
			->exec('rm -rf vendor')
			->exec('rm -f composer.lock')
			->run();

		// recreate packages
		$this->say('Installing composer and node packages');
		$this->taskExecStack()
			->setVerbosityThreshold(
				VerbosityThresholdInterface::VERBOSITY_DEBUG
			)
			->stopOnFail()
			->exec('npm install')
			->exec('composer install')
			->run();
	}

	public function devInstallScripts(): void
	{
		$tailScript = <<< 'TAILSCRIPT'

        tail-booka () {
            if [ -z "$1" ] ; then
                echo "Please specify a file for monitoring"
                return
            fi

            tail -f $1 | awk '
                        {matched=0}
                        /INFO:/    {matched=1; print "\033[0;37m" $0 "\033[0m"}   # WHITE
                        /NOTICE:/  {matched=1; print "\033[0;36m" $0 "\033[0m"}   # CYAN
                        /WARNING:/ {matched=1; print "\033[0;34m" $0 "\033[0m"}   # BLUE
                        /ERROR:/   {matched=1; print "\033[0;31m" $0 "\033[0m"}   # RED
                        /ALERT:/   {matched=1; print "\033[0;35m" $0 "\033[0m"}   # PURPLE
                        matched==0            {print "\033[0;33m" $0 "\033[0m"}   # YELLOW
                '
        }

        TAILSCRIPT;
		$command = "cat << EOF >> ~/.bashrc
            $tailScript
            ";
		$this->taskExecStack()
			->setVerbosityThreshold(
				VerbosityThresholdInterface::VERBOSITY_DEBUG
			)
			->stopOnFail()
			->exec($command)
			->run();
	}
}
