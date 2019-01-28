<?php declare(strict_types = 1);
namespace PharIo\Phive\RegressionTests;

class PurgeCommandTest extends RegressionTestCase {
    public function testDeletesPurgablePhar(): void {
        $this->addPharToRegistry('phpunit', '5.3.4', 'phpunit-5.3.4.phar');

        $this->assertTrue(
            $this->getPhiveHomeDirectory()->child('phars')->file('phpunit-5.3.4.phar')->exists()
        );

        $this->runPhiveCommand('purge');

        $this->assertFalse(
            $this->getPhiveHomeDirectory()->child('phars')->file('phpunit-5.3.4.phar')->exists()
        );
    }
}
