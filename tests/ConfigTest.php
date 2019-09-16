<?php
declare(strict_types=1);

/*
 * This file is part of the config-simple-php package.
 *
 * (c) Pascal Eberhard <pascal-eberhard-programming@posteo.de>
 *
 * For the full copyright and license information, please view the <https://github.com/pascal-eberhard/config-php/blob/master/LICENSE>
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
     * @covers ::baseDir
     *
     * Shell: (vendor/bin/phpunit tests/ConfigTest.php --filter testBaseDir)
     */
    public function testBaseDir()
    {
        $this->assertTrue(true);
        Config::baseDir();
    }
//
//    /**
//     * @see self::testPathAddTailingSeparator
//     */
//    public function dataPathAddTailingSeparator() {
//        return [
//            /**
//             * @param string $result Expected result
//             * @param string $path
//             * @param string $separator
//             */
//            ['/', '', '/'],
//            ['/', '/', '/'],
//            ['\\', '', '\\'],
//            ['\\', '\\', '\\'],
//            [DIRECTORY_SEPARATOR, '', DIRECTORY_SEPARATOR],
//            [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR],
//        ];
//    }
//
//    /**
//     * @see self::testPathFindVendorParent
//     */
//    public function dataPathFindVendorParent() {
//        return [
//            /**
//             * @param string $result Expected result
//             * @param string $path
//             */
////            ['/', '/'],
//            ['C:\\projects\\my-project', 'C:\\projects\\my-project\\vendor\\package\\vendor\\file.ext'],
//        ];
//    }
//
//    /**
//     * @covers ::pathAddTailingSeparator
//     * @dataProvider dataPathAddTailingSeparator
//     *
//     * @param string $result Expected result
//     * @param string $path
//     * @param string $separator
//     * Shell: (vendor/bin/phpunit tests/ProjectDirFinder/UtilsTest.php --filter testPathAddTailingSeparator)
//     */
//    public function testPathAddTailingSeparator(string $result, string $path, string $separator)
//    {
//        $this->assertEquals($result, Utils::pathAddTailingSeparator($path, $separator));
//    }
////
////    /**
////     * @covers ::pathFindVendorParent
////     * @dataProvider dataPathFindVendorParent
////     *
////     * @param string $result Expected result
////     * @param string $path
////     * Shell: (vendor/bin/phpunit tests/ProjectDirFinder/UtilsTest.php --filter testPathFindVendorParent)
////     */
////    public function testPathFindVendorParent(string $result, string $path)
////    {
////        $this->assertEquals($result, Utils::pathFindVendorParent($path));
////    }
//
//
//    /**
//     * @see self::testPathSplit
//     */
//    public function dataPathSplit() {
//        return [
//            /**
//             * @param string[] $result Expected result
//             * @param string $path
//             */
////            [[], ''],
////            ['/', '/'],
//            [
//                [
//                    'C:',
//                    '\\',
//                    'projects',
//                    '\\',
//                    'my-project',
//                    '\\',
//                    'vendor',
//                    '\\',
//                    'package',
//                    '\\',
//                    'vendor',
//                    '\\',
//                    'file.ext',
//                ], 'C:\\projects\\my-project\\vendor\\package\\vendor\\file.ext'
//            ],
//        ];
//    }

//    /**
//     * @covers ::pathSplit
//     * @dataProvider dataPathSplit
//     *
//     * @param string[] $result Expected result
//     * @param string $path
//     * Shell: (vendor/bin/phpunit tests/ProjectDirFinder/UtilsTest.php --filter testPathSplit)
//     */
//    public function testPathSplit(array $result, string $path)
//    {
//        $this->assertTrue(true);
//        print PHP_EOL . var_export(Utils::pathSplit($path)) . PHP_EOL;
//        #$this->assertEquals($result, Utils::pathSplit($path));
//    }
}
