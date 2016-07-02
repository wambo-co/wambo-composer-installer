<?php
namespace Wambo\ComposerInstaller;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;

/**
 * WamboInstaller is an composer installer to add a "wambo-module" to a
 * modules.json in the project config.
 *
 * @package Wambo\ComposerInstaller
 */
class WamboInstaller extends LibraryInstaller
{

    const PACKAGE_TYPE = 'wambo-module';

    const MODULES_JSON_PATH = 'config/wambo/modules.json';

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
        // display info on "composer update" on command line
        echo 'add  ' . $package->getName() . ' to wambo modules';
        echo PHP_EOL;

        $autoload = $package->getAutoload();
        if(array_key_exists('psr-4', $autoload)){
            $namespaces = array_keys($autoload['psr-4']);
            if(!empty($namespaces)){
                $namespace_parts = array_filter(preg_split('/\\\\/', array_pop($namespaces)));
                $module_classname = $namespace_parts[count($namespace_parts) -1];

                if( file_exists(self::MODULES_JSON_PATH) ){
                    $modules_json = file_get_contents(self::MODULES_JSON_PATH);
                    $modules = json_decode($modules_json, true);
                }else{
                    $modules = array();
                }


                $module_entity = array(
                    'name' => $module_classname,
                    'namespace' => implode('\\', $namespace_parts)
                );
                array_push($modules, $module_entity);

                $modules = array_unique($modules, SORT_REGULAR);
                file_put_contents(self::MODULES_JSON_PATH, json_encode($modules, JSON_PRETTY_PRINT));
            }
        }

        parent::install($repo, $package);
    }
}