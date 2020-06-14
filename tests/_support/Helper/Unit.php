<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Module;
use Codeception\Step;
use Codeception\TestInterface;

class Unit extends Module
{

    // HOOK: used after configuration is loaded
    public function _after(TestInterface $test)
    {
    }

    // HOOK: before each suite

    public function _afterStep(Step $step)
    {
    }

    // HOOK: after suite

    public function _afterSuite()
    {
    }

    // HOOK: before each step

    public function _before(TestInterface $test)
    {
    }

    // HOOK: after each step

    public function _beforeStep(Step $step)
    {
    }

    // HOOK: before test

    public function _beforeSuite($settings = [])
    {
    }

    // HOOK: after test

    public function _failed(TestInterface $test, $fail)
    {
    }

    // HOOK: on fail

    public function _initialize()
    {
    }
}
