<?php

namespace Wambo\ComposerInstaller;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

/**
 * Class Plugin
 *
 * @package Wambo\ComposerInstaller
 */
class Plugin implements PluginInterface
{

    /**
     * Add The WamboInstaller to compser
     *
     * @param Composer    $composer
     * @param IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new WamboInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }
}
