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
 * @category   Modules|Api|Core
 * @package    Users
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2020 - David's Neighbour Part., Ltd.
 * @license    https://inkohsamui.com/license.txt proprietary
 * @version    11.9.65
 * @link       https://inkohsamui.com/
 * @since      11.7.110
 * @filesource
 */

declare(strict_types=1);

namespace Booka\Testing\Unit\Users;

use Booka\Core\Users\Passphrase;
use Codeception\Test\Unit;
use Exception;

/**
 * Class PassphraseTest
 *
 * @package Booka\Testing\Unit\Users
 */
class PassphraseTest extends Unit
{

    /**
     * Test if exception is thrown if vocab file is not available
     *
     * @throws \Exception
     * @return void
     */
    public function testPassphraseVocabLocation()
    {

        static::expectExceptionMessage('vocabulary not found');
        Passphrase::create(5, __DIR__ . '/nonexistent.txt');
    }

    /**
     * Test if exception is thrown if vocab file is empty
     *
     * @throws \Exception
     * @return void
     */
    public function testPassphraseVocabEmpty()
    {

        static::expectExceptionMessage('vocabulary empty');
        Passphrase::create(5, __DIR__ . '/empty.txt');
    }

    public function testCreate()
    {

        $aPassphrase = Passphrase::create();
        static::assertTrue(is_string($aPassphrase));
        static::assertTrue(strlen($aPassphrase) > 11);
    }

    public function testGetSamples()
    {

        try {
            $iAmount = random_int(10, 30);
        } catch (Exception $e) {
            return;
        }
        $aPassphrases = Passphrase::getSamples($iAmount);
        static::assertTrue(is_array($aPassphrases));
        static::assertTrue(count($aPassphrases) === $iAmount);
        foreach ($aPassphrases as $sPassphrase) {
            static::assertTrue(is_string($sPassphrase));
            static::assertTrue(strlen($sPassphrase) > 11);
        }
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCheckHash()
    {
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testGet()
    {
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCheck()
    {
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testSet()
    {
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCheckAlgorithm()
    {
    }
}
