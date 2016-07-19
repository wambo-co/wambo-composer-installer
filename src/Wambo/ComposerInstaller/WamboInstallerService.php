<?php

namespace Wambo\ComposerInstaller;

use Composer\Package\PackageInterface;
use Wambo\ComposerInstaller\Exception\InvalidArgumentException;

class WamboInstallerService
{

    private $package;

    /**
     * WamboInstallerService constructor.
     * @param $package
     */
    public function __construct(PackageInterface $package)
    {
        $this->package = $package;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getAutoloadNamespace()
    {
        $autoload = $this->package->getAutoload();

        if ( !array_key_exists(WamboInstaller::AUTOLOAD_TYPE, $autoload) ) {
            throw new \Exception('No PSR-4 Namespace found in package');
        }

        $namespaces = $autoload[WamboInstaller::AUTOLOAD_TYPE];
        $namespace_array = array_keys($namespaces);

        if (count($namespace_array) !== 1) {
            throw new \Exception('No unique PSR-4 namespace.');
        }

        return $namespace_array[0];
    }

    /**
     * @return string
     */
    public function getBootstrapClassName() : string
    {
        $extra = $this->package->getExtra();

        if(!array_key_exists(WamboInstaller::EXTRA_BOOTSTRAP_CLASS_KEY, $extra)){
            throw new InvalidArgumentException('Wambo bootstap class not found');
        }

        return $extra[WamboInstaller::EXTRA_BOOTSTRAP_CLASS_KEY];
    }
}
