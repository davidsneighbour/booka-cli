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
 * PHP Version 8.1
 *
 * @category   Cli
 * @package    Cli
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2019 - David's Neighbour Part., Ltd.
 * @license    https://getbooka.app/license.txt proprietary
 * @version    11.18
 * @link       https://getbooka.app/
 * @since      11.18
 * @filesource
 */

declare(strict_types=1);

namespace Booka\Cli\Traits;

/**
 * Trait QualityInsurance
 *
 * @package Booka\Cli\Traits
 */
trait QualityInsurance
{

	/**
	 * @psalm-suppress PossiblyUnusedMethod
	 */
	public function qiBaselines(): void
	{
		$this->qiPhanBaseline();
		$this->qiPsalmBaseline();
		$this->qiPhpstanBaseline();
	}

	/**
	 * @psalm-suppress PossiblyUnusedMethod
	 */
	public function qiPhanBaseline(): void
	{
		$command = $this->getCommonPhanSetup();
		$command .= '--save-baseline .phan/baseline.php ';
		$this->_exec($command);
	}

	/**
	 * @param bool   $baseline
	 * @param string $output
	 *
	 * @return string
	 */
	private function getCommonPhanSetup($baseline = true, $output = 'text'): string
	{
		$command = 'PHAN_DISABLE_XDEBUG_WARN=1 && ';
		$command .= 'PHAN_ALLOW_XDEBUG=0 && ';
		$command .= './vendor/bin/phan ';
		$command .= '--config-file .phan/config.php ';
		$command .= '--analyze-twice ';
		$command .= '--progress-bar ';
		switch ($output) {
			case 'verbose':
				$command .= '--output-mode=verbose ';
				break;

			case 'text':
			default:
				$command .= '--output-mode=text ';
				break;
		}
		$command .= '--color --color-scheme=eclipse_dark ';
		if ($baseline === false) {
			$command .= '--load-baseline .phan/baseline.php ';
		}
		$command .= '--backward-compatibility-checks ';
		return $command;
	}

	/**
	 * @psalm-suppress PossiblyUnusedMethod
	 */
	public function qiPsalmBaseline(): void
	{
		$command = './vendor/bin/psalm.phar --set-baseline=psalm-baseline.xml';
		$this->_exec($command);
		$command = './vendor/bin/psalm.phar --update-baseline';
		$this->_exec($command);
	}

	/**
	 * @psalm-suppress PossiblyUnusedMethod
	 */
	public function qiPhpstanBaseline(): void
	{
		$command = './vendor/bin/phpstan analyse -l 8 -c phpstan.neon --generate-baseline';
		$this->_exec($command);
	}

	/**
	 * @psalm-suppress PossiblyUnusedMethod
	 */
	public function qiPhan(): void
	{
		$command = $this->getCommonPhanSetup(false);
		$this->_exec($command);
	}

	/**
	 * @psalm-suppress PossiblyUnusedMethod
	 */
	public function qiPhpstan(): void
	{
		$this->_exec('./bin/phpstan analyse -c phpstan.neon src -l max --ansi');
	}

	/**
	 * @psalm-suppress PossiblyUnusedMethod
	 */
	public function qiPsalm(): void
	{
		$this->_exec('./vendor/bin/psalm.phar');
	}

	/**
	 * @psalm-suppress PossiblyUnusedMethod
	 */
	public function qiPhpdoccheck(): void
	{
		$this->_exec('./vendor/bin/php-doc-check src');
	}

	public function qiCheck(string $sample): void
	{
		$this->_exec('./vendor/bin/psalm.phar --taint-analysis --show-info=true ' . $sample);
		$this->_exec('./vendor/bin/phpstan.phar analyse ' . $sample);
	}
}
