<?php declare(strict_types=1);

namespace Helper;

use Codeception\Module;

/**
 * Class Api
 *
 * @package Helper
 */
class Api extends Module
{

    public function seeResponseIsHtml()
    {

        $response = $this->getModule('REST')->response;
        $this->assertRegExp(
            '~^<!DOCTYPE HTML(.*?)<html>.*?<\/html>~m',
            $response
        );
    }

    public function seeResponseIsNotHtml()
    {

        $response = $this->getModule('REST')->response;
        $this->assertNotRegExp(
            '~^<!DOCTYPE HTML(.*?)<html>.*?<\/html>~m',
            $response
        );
    }
}
