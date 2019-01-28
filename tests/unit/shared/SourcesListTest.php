<?php declare(strict_types = 1);
namespace PharIo\Phive;

use PharIo\FileSystem\Filename;
use PharIo\Version\AnyVersionConstraint;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PharIo\Phive\SourcesList
 */
class SourcesListTest extends TestCase {
    public function testThrowsExceptionForUnknownAlias(): void {
        $this->expectException(SourcesListException::class);
        $this->getSourcesList()->getSourceForAlias(
            new PharAlias(
                'foo',
                new AnyVersionConstraint(),
                new AnyVersionConstraint()
            )
        );
    }

    public function testThrowsExceptionIfMultipleRepositoriesAreMatching(): void {
        $this->expectException(SourcesListException::class);
        $this->getSourcesList()->getSourceForAlias(
            new PharAlias('phpunit', new AnyVersionConstraint(), new AnyVersionConstraint())
        );
    }

    public function testReturnsExpectedSource(): void {
        $expected = new Source('phar.io', new Url('https://phar.io'));
        $this->assertEquals(
            $expected,
            $this->getSourcesList()->getSourceForAlias(
                new PharAlias('phpab', new AnyVersionConstraint(), new AnyVersionConstraint())
            )
        );
    }

    private function getSourcesList(): SourcesList {
        return new SourcesList(
            new XmlFile(
                new Filename(__DIR__ . '/../../data/repositories.xml'),
                'https://phar.io/repository-list',
                'repositories'
            )
        );
    }
}
