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

use Robo\Contract\VerbosityThresholdInterface;

/**
 * Trait Build
 *
 * Building theme files
 */
trait Build
{

    /**
     * @var array $templates
     */
    private $templates = [
        'default',
        'followup-borderbounce',
        'password-reset',
        'send-voucher',
    ];

    /**
     * Create transactional email templates
     *
     * @see https://github.com/mjmlio/mjml
     */
    public function mailtemplates(): void
    {
        foreach ($this->templates as $template) {
            $command = 'mjml -v ';
            $command .= 'assets/emailtemplates/' . $template . '.mjml ';

            $this->taskExec($command)
                ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
                ->run();
        }

        $this->say('Process Email Templates');

        $job = $this->taskParallelExec();

        foreach ($this->templates as $template) {
            $command = 'mjml ';
            $command .= 'assets/emailtemplates/' . $template . '.mjml ';
            $command .= '--config.minify=true ';
            $command .= '--config.minifyOptions=\'{"minifyCSS": true}\' ';
            $command .= '--output ./public/theme/templates/email/ ';

            $job->process($command);
        }

        $job->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
            ->run();
    }

    /**
     * Process stylesheets and theme files
     *
     * @see https://webdesign.tutsplus.com/series/postcss-deep-dive--cms-889
     * @see https://www.postcss.parts/
     * @see https://github.com/jdrgomes/awesome-postcss
     */
    public function build(): void
    {
        $set = $this->askFull();

        $this->clean();

        $this->taskExecStack()
            ->exec(
                ($set === 'default theme')
                    ? 'npm run-script css'
                    : 'npm run-script css2'
            )
            ->run();
    }

    /**
     * @return string
     */
    private function askFull(): string
    {
        return $this->io()->choice(
            'Which installation?',
            [
                '1' => 'default theme',
                '2' => 'full theme set',
            ],
            'default theme'
        );
    }

    public function buildCli()
    {
        $this->taskExecStack()
            ->stopOnFail()
            ->exec('cd ../cli/')
            ->exec('php ./vendor/bin/robo build')
            ->exec('cp dist/booka ../app/')
            ->exec('cd ../app/')
            ->run();
    }

}
