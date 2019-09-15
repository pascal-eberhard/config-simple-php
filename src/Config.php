<?php
declare(strict_types=1);

/*
 * This file is part of the config-simple-php package.
 *
 * (c) Pascal Eberhard <pascal-eberhard-programming@posteo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace PEPrograms\ConfigSimple;

/**
 * Simple config
 *
 * @copyright 2019 Pascal Eberhard <pascal-eberhard-programming@posteo.de>
 * @see <https://github.com/pascal-eberhard/config-simple-php/blob/master/README.md>
 */
class Config
{
    
    /**
     * Default charset
     *
     * @var string
     */
    const CHARSET = 'utf8';

    /**
     * Default directory path separator
     *
     * @var string
     */
    const DIRECTORY_SEPARATOR = '/';

    /**
     * Base dir
     *
     * @var string
     */
    private static $baseDir = '';

    /**
     * Base dir set?
     *
     * @var bool
     */
    private static $baseDirSet = false;

    /**
     * Base dir, windows format
     *
     * @var string
     */
    private static $baseDirWindows = '';

    /**
     * Get base dir
     *
     * @return string
     * @throws \LogicException
     * @throws \UnexpectedValueException
     */
    public static function baseDir(): string
    {
        throw new \LogicException('PENDING');
        /** @var ProjectDirFinder\MethodInterface|null $finder */
        $finder = null;
        if (self::$baseDirSet) {
            return self::$baseDir;
        } elseif (!self::$baseDirSet) {
            $finder = new ProjectDirFinder\ComposerClassLoaderAndReflection();
            self::$baseDirSet = $finder->usable();
        } elseif (!self::$baseDirSet) {
            $finder = new ProjectDirFinder\ComposerClassLoader();
            self::$baseDirSet = $finder->usable();
        }

        if (null === $finder) {
            throw new \LogicException('No usable method found');
        }
        self::$baseDir = $finder->find();

        # @todo complete

        self::$baseDir = PathString\Utils::windowsToLinux(__FILE__);
        if ('/src/Config.php' !== mb_substr(self::$baseDir, -15, 15, Provider::CHARSET)) {
            throw new \UnexpectedValueException('Unexpected file path: ' . self::$baseDir);
        }

        self::$baseDir = mb_substr(self::$baseDir, 0, -14, Provider::CHARSET);
        self::$baseDirSet = true;
        self::$baseDirWindows = PathString\Utils::linuxToWindows(self::$baseDir);

        return self::$baseDir;
    }

    /**
     * Get base dir, windows format
     *
     * @return string
     */
    public static function baseDirWindows(): string
    {
        if (self::$baseDirSet) {
            return self::$baseDirWindows;
        }

        self::baseDir();

        return self::$baseDirWindows;
    }
// @todo Integrate simple versions
//    /**
//     * Vendor folder name
//     *
//     * @var string
//     */
//    protected const VENDOR = 'vendor';
//
//    /**
//     * Add tailing directory separator to path, if missing
//     *
//     * @param string $path
//     * @param string $separator Optional, the directory separator default: DIRECTORY_SEPARATOR
//     * @return string
//     * @throws \InvalidArgumentException
//     */
//    public static function pathAddTailingSeparator(string $path, string $separator = DIRECTORY_SEPARATOR): string
//    {
//        if ('' == $separator) {
//            throw new \InvalidArgumentException('$separator must not be empty');
//        }
//
//        if ('' == $path) {
//            return $separator;
//        }
//
//        if (mb_substr($path, -1, 1, MyConfig::CHARSET) !== $separator) {
//            return $path . $separator;
//        }
//
//        return $path;
//    }
//
//    /**
//     * Find vendor folder parent folder
//     *
//     * @param string $path
//     * @return string
//     * @throws \InvalidArgumentException
//     * @throws \LogicException
//     */
//    public static function pathFindVendorParent(string $path): string
//    {
//        if ('' == $path) {
//            throw new \InvalidArgumentException('$path must not be empty');
//        }
//
//        $newPath = $path;
//        print PHP_EOL . var_export(
//            [
//                    '$path' => $path,
//                    'basename.$path' => basename($path),
//                    'basename.dirname.$path' => basename(dirname($path)),
//                    'dirname.$path' => dirname($path),
//                    'pathinfo.$path' => pathinfo($path),
//                    'pathinfo.dirname.$path' => pathinfo(dirname($path)),
//            ]
//        ) . PHP_EOL
//        ;
////        while (false !== mb_stripos($newPath, self::VENDOR, 0, MyConfig::CHARSET)) {
////            $newPath = dirname($newPath);
////
////            if ('' == $newPath) {
////                throw new \LogicException('Empty path, should not happen');
////            }
////        }
//
//        return $newPath;
//    }
//
//    /**
//     * Split path
//     *
//     * @param string $path
//     * @return string[] List of path parts and separators
//     */
//    public static function pathSplit(string $path): array
//    {
//        if ('' == $path) {
//            return [];
//        }
//
//        $parts = [];
//        for ($i = 0; $i < 8; ++$i) {
//            array_unshift($parts, [
//                'basename' => basename($path),
//                'dirname' => dirname($path),
//                'dirname.2' => dirname($path, 2),
//            ]);
//            $path = dirname($path);
//        }
////        do {
////            $parts[] = basename($path);
////            $path = dirname($path);
////
////            #$path = '';
////        } while ('' != $path);
//
//        return $parts;
//    }
}
