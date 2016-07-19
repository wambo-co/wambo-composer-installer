<?php

namespace Wambo\ComposerInstaller;

use PHPUnit\Framework\TestCase;

/**
 * Class PluginTest
 *
 * @package Wambo\ComposerInstaller
 */
class PluginTest extends TestCase
{
    /**
     * @test
     */
    public function testConstructor()
    {
        // arrange
        $plugin = new Plugin();

        // act

        // assert
        $this->assertInstanceOf(__NAMESPACE__ . '\\Plugin', $plugin);
        $this->assertInstanceOf('Composer\\Plugin\\PluginInterface', $plugin);
    }


}
