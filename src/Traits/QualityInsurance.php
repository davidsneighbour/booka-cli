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
 * Github URL
 */
define('GHB', 'https://github.com/');
/**
 * Github Release Download URL
 */
define('RDL', '/releases/download/');
/**
 * Github Release download URL for substitution
 */
define('GIT', 'https://github.com/%s/releases/download/%s/%s');

/**
 * Trait QualityInsurance
 *
 * @package Booka\Cli\Traits
 */
trait QualityInsurance
{

    /**
     * @var string
     */
    private static $psalm = './vendor/bin/psalm.phar';

    /**
     * @var string
     */
    private static $phan = './bin/phan';

    /**
     * @var string
     */
    private static $phpstan = './bin/phpstan';

    /**
     * @var string
     */
    private static $phpdoccheck = './bin/php-doc-check';

    /**
     * @var array<string,string>
     */
    private static $phars = [
        GHB . 'phan/phan' . RDL . '2.5.0/phan.phar' => './bin/phan',
        GHB . 'phpstan/phpstan' . RDL . '0.12.11/phpstan.phar' => './bin/phpstan',
        GHB . 'NielsdeBlaauw/php-doc-check' . RDL . 'v0.2.2/php-doc-check.phar' => './bin/php-doc-check',
        'https://phar.phpunit.de/phploc-5.0.0.phar' => './bin/phploc',
    ];

    public function qiBaselines()
    {
        $this->qiPhanBaseline();
        $this->qiPsalmBaseline();
        $this->qiPhpstanBaseline();
    }

    public function qiPhanBaseline()
    {
        $command = static::$phan . ' -k .phan/config.php --load-baseline .phan/baseline.php -C --color-scheme=vim ';
        $command .= '--progress-bar -b -x -t -z -S --save-baseline .phan/baseline.php';
        $this->_exec($command);
    }

    public function qiPsalmBaseline()
    {
        $command = static::$psalm . ' --set-baseline=psalm-baseline.xml';
        $this->_exec($command);
    }

    public function qiPhpstanBaseline()
    {
        $command = static::$phpstan . ' analyse -l 8 -c phpstan.neon --error-format baselineNeon src ';
        $command .= '> phpstan-baseline.neon';
        $this->_exec($command);
    }

    public function qiPhan()
    {
        $command = 'PHAN_DISABLE_XDEBUG_WARN=1 && ' . static::$phan . ' -k .phan/config.php ';
        $command .= '--load-baseline .phan/baseline.php -C --color-scheme=vim ';
        $command .= '--progress-bar -b -x -t -z -S';
        $this->_exec($command);
    }

    public function qiPhanHtml()
    {
        $command = static::$phan . ' -k .phan/config.php --load-baseline .phan/baseline.php -C --color-scheme=vim';
        $command .= ' --progress-bar -b -x -t -z -S -m=html -o=phan.html';
        $this->_exec($command);
    }

    public function qiPhpstan()
    {
        $command = static::$phpstan . ' analyse -c phpstan.neon src -l max --ansi';
        $this->_exec($command);
    }

    public function qiPsalm()
    {
        $command = static::$psalm;
        $this->_exec($command);
    }

    public function qiSetup()
    {
        set_time_limit(0);
        foreach (static::$phars as $url => $target) {
            $fp = fopen($target, 'w+');
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 50);
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_exec($ch);
            curl_close($ch);
            $this->_exec('chmod +x ' . $target);
        }
    }

    public function qiPhpdoccheck()
    {
        $command = sprintf("%s src", static::$phpdoccheck);
        $this->_exec($command);
    }

}
