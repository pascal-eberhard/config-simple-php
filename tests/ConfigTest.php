<?php
declare(strict_types=1);

/*
 * This file is part of the config-simple-php package.
 *
 * (c) Pascal Eberhard <pascal-eberhard-programming@posteo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace PEPrograms\ConfigSimple\Tests;

use PEPrograms\ConfigSimple\Config;
use PHPUnit\Framework\TestCase;

/**
 * @copyright 2019 Pascal Eberhard <pascal-eberhard-programming@posteo.de>
 * @coversDefaultClass \PEPrograms\ConfigSimple\Config
 *
 * Shell: (vendor/bin/phpunit tests/ConfigTest.php)
 */
class ConfigTest extends TestCase
{

    /**
     * Self file path suffix
     * Linux path format
     * Prefix: Config::baseDir() // with tailing "/"
     *
     * @var string
     */
    private const SELF_FILE_SUFFIX = 'tests/ConfigTest.php';

    /**
     * @see self::testPathLinuxToWindows
     */
    public function dataPathLinuxToWindows()
    {
        return [
            /**
             * @param string $result Converted path
             * @param string $path Must be absolute
             *
             * Hint: The drive letter is always converted to lower case
             */
            ['..\\mY\\Path', '../mY/Path'],
            ['..\\mY\\Path\\', '../mY/Path/'],
            ['C:\\windows', '/c/windows'],
            ['C:\\Windows', '/c/Windows'],
            ['C:\\windows\\', '/c/windows/'],
            ['C:\\Windows\\', '/c/Windows/'],
            ['mY\\Path', 'mY/Path'],
            ['mY\\Path\\', 'mY/Path/'],
            ['path', 'path'],
        ];
    }

    /**
     * @see self::testPathWindowsToLinux
     */
    public function dataPathWindowsToLinux()
    {
        return [
            /**
             * @param string $result Converted path
             * @param string $path Must be absolute
             *
             * Hint: The drive letter is always converted to lower case
             */
            ['../mY/Path', '..\\mY\\Path'],
            ['../mY/Path/', '..\\mY\\Path\\'],
            ['/c/windows', 'C:\\windows'],
            ['/c/Windows', 'c:\\Windows'],
            ['/c/windows/', 'C:\\windows\\'],
            ['/c/Windows/', 'c:\\Windows\\'],
            ['mY/Path', 'mY\\Path'],
            ['mY/Path/', 'mY\\Path\\'],
            ['path', 'path'],
        ];
    }

    /**
     * @covers ::baseDir
     *
     * Shell: (vendor/bin/phpunit tests/ConfigTest.php --filter testBaseDir)
     */
    public function testBaseDir()
    {
        $path = Config::pathWindowsToLinux(__FILE__);
        $posVendor = mb_stripos($path, '/vendor/', 0, Config::CHARSET_UTF8);
        if (false !== $posVendor) {
            $path = mb_substr($path, 0, $posVendor + 1, Config::CHARSET_UTF8) . self::SELF_FILE_SUFFIX;
        }

        $this->assertEquals(
            $path,
            Config::baseDir() . self::SELF_FILE_SUFFIX,
            'This file path, not in vendor folder'
        );
    }

    /**
     * @covers ::pathLinuxToWindows
     * @dataProvider dataPathLinuxToWindows
     *
     * @param string $result Converted path
     * @param string $path Must be absolute
     *
     * Shell: (vendor/bin/phpunit tests/ConfigTest.php --filter testPathLinuxToWindows)
     */
    public function testPathLinuxToWindows(string $result, string $path)
    {
        $this->assertEquals($result, Config::pathLinuxToWindows($path));
    }

    /**
     * @covers ::pathWindowsToLinux
     * @dataProvider dataPathWindowsToLinux
     *
     * @param string $result Converted path
     * @param string $path Must be absolute
     *
     * Shell: (vendor/bin/phpunit tests/ConfigTest.php --filter testPathWindowsToLinux)
     */
    public function testPathWindowsToLinux(string $result, string $path)
    {
        $this->assertEquals($result, Config::pathWindowsToLinux($path));
    }
}
