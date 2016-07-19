<?php
namespace Wambo\ComposerInstaller;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Wambo\Core\Module\JSONModuleStorage;
use Wambo\Core\Module\Module;
use Wambo\Core\Module\ModuleMapper;
use Wambo\Core\Module\ModuleRepository;

/**
 * WamboInstaller is an composer installer to add a "wambo-module" to a
 * modules.json in the project config.
 *
 * @package Wambo\ComposerInstaller
 */
class WamboInstaller extends LibraryInstaller
{

    const PACKAGE_TYPE = 'wambo-module';
    const EXTRA_BOOTSTRAP_CLASS_KEY = 'class';
    const AUTOLOAD_TYPE = 'psr-4';

    const MODULES_JSON_FILENAME = 'modules.json';

    private $moduleRepository;

    /**
     * Decides if the installer supports the given type
     *
     * @param  string $packageType
     * @return bool
     */
    public function supports($packageType)
    {
        return self::PACKAGE_TYPE === $packageType;
    }

    /**
     * Add a json node to the modules.json file.
     *
     * @param InstalledRepositoryInterface $repo repository in which to check
     * @param PackageInterface $package package instance
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        $this->bootstrap();

        // display info on "composer update" on command line
        echo 'add  ' . $package->getName() . ' to wambo modules';
        echo PHP_EOL;

        $wamboInstallerService = new WamboInstallerService($package);

        $className = $wamboInstallerService->getBootstrapClassName();
        $name = $package->getName();
        $version = $package->getVersion();

        $module = new Module($name, $version, $className);
        $this->moduleRepository->add($module);

        parent::install($repo, $package);
    }

    private function bootstrap()
    {
        $filesystemAdapter = new Local($this->vendorDir);
        $filesystem = new Filesystem($filesystemAdapter);
        $mapper = new ModuleMapper();
        $storage = new JSONModuleStorage($filesystem, self::MODULES_JSON_FILENAME);

        $this->moduleRepository = new ModuleRepository($storage, $mapper);
    }
}
