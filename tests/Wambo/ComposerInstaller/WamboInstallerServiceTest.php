<?php

namespace Wambo\ComposerInstaller;

use Composer\Package\PackageInterface;
use PHPUnit\Framework\TestCase;
use Wambo\ComposerInstaller\Exception\InvalidArgumentException;

/**
 * Class WamboInstallerServiceTest
 *
 * @package Wambo\ComposerInstaller
 */
class WamboInstallerServiceTest extends TestCase
{

    /**
     * @test
     */
    public function testGetBootstrapClass_Success()
    {
        // arrange
        $package = $this->getMockBuilder(PackageInterface::class)->getMock();
        $package->method('getExtra')->willReturn(
            array(WamboInstaller::EXTRA_BOOTSTRAP_CLASS_KEY => 'Wambo\\Test\\Bootstrap')
        );

        /** @var PackageInterface $package */
        $wamboInstallerService = new WamboInstallerService($package);

        //act
        $className = $wamboInstallerService->getBootstrapClassName();

        // assert
        $this->assertEquals($className, 'Wambo\\Test\\Bootstrap');
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function testGetBoostrapClass_Fail_NoKeyFound()
    {
        // arrange
        $package = $this->getMockBuilder(PackageInterface::class)->getMock();
        $package->method('getExtra')->willReturn(
            array('klass' => 'Wambo\\Test\\Bootstrap')
        );
        /** @var PackageInterface $package */
        $wamboInstallerService = new WamboInstallerService($package);

        //act
        $className = $wamboInstallerService->getBootstrapClassName();

        // assert
        $this->assertEquals($className, 'Wambo\\Test\\Bootstrap');
    }

    /**
     * @test
     */
    public function testGetPSR4AutoloadReturnNamespaceString()
    {
        // arrange
        $package = $this->getMockBuilder(PackageInterface::class)->getMock();
        $package->method('getAutoload')->willReturn(
            array('psr-4' => array(
                '\\Wambo\\SomePackage' => 'src/Wambo/SomePackage'
            ))
        );

        /** @var PackageInterface $package */
        $wamboInstallerService = new WamboInstallerService($package);

        //act
        $namespaceString = $wamboInstallerService->getAutoloadNamespace();

        //assert
        $this->assertEquals('\\Wambo\\SomePackage', $namespaceString);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetPSR4AutoloadThrowExceptionNotUnique()
    {
        // arrange
        $package = $this->getMockBuilder(PackageInterface::class)->getMock();
        $package->method('getAutoload')->willReturn(
            array('PSR-4' => array(
                '\\Wambo\\SomePackage' => 'src/Wambo/SomePackage',
                '\\Wambo\\OtherPackage' => 'src/Wambo/OtherPackage'
            ))
        );

        /** @var PackageInterface $package */
        $wamboInstallerService = new WamboInstallerService($package);

        //act
        $wamboInstallerService->getAutoloadNamespace();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetPSR4AutoloadThrowExceptionNoNamespaceFound()
    {
        // arrange
        $package = $this->getMockBuilder(PackageInterface::class)->getMock();
        $package->method('getAutoload')->willReturn(
            array('PSR-4' => array(
            ))
        );

        /** @var PackageInterface $package */
        $wamboInstallerService = new WamboInstallerService($package);

        //act
        $wamboInstallerService->getAutoloadNamespace();
    }
}