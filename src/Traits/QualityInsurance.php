<?php

/**
 * BooKa 13 CLI
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
        $command = './vendor/bin/phan -k .phan/config.php --load-baseline .phan/baseline.php -C --color-scheme=vim ';
        $command .= '--progress-bar -b -x -t -z -S --save-baseline .phan/baseline.php';
        $this->_exec($command);
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function qiPsalmBaseline(): void
    {
        $command = './vendor/bin/psalm.phar --set-baseline=psalm-baseline.xml';
        $this->_exec($command);
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function qiPhpstanBaseline(): void
    {
        $command = './vendor/bin/phpstan analyse -l 8 -c phpstan.neon --error-format baselineNeon src ';
        $command .= '> phpstan-baseline.neon';
        $this->_exec($command);
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function qiPhan(): void
    {
        $command = 'PHAN_DISABLE_XDEBUG_WARN=1 && ./vendor/bin/phan -k .phan/config.php ';
        $command .= '--load-baseline .phan/baseline.php -C --color-scheme=vim ';
        $command .= '--progress-bar -b -x -t -z -S';
        $this->_exec($command);
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function qiPhanHtml(): void
    {
        $command = './vendor/bin/phpstan -k .phan/config.php --load-baseline .phan/baseline.php -C --color-scheme=vim';
        $command .= ' --progress-bar -b -x -t -z -S -m=html -o=phan.html';
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

}
