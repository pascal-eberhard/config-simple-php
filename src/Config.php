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
     * UTF8 charset for internal use
     *
     * @var string
     */
    private const CHARSET_UTF8 = 'utf8';

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
     * Base dir, real format
     * For example, use linux path internally, at Windows
     *
     * @var string
     */
    private static $baseDirReal = '';

    /**
     * Operating system key
     *
     * @var string
     */
    private static $operatingSystem = '';

    /**
     * Operating system, is Windows?
     *
     * @var bool
     */
    private static $operatingSystemIsWindows = false;

    /**
     * Operating system, is Windows, is set?
     *
     * @var bool
     */
    private static $operatingSystemIsWindowsIsSet = false;

    /**
     * Get base dir
     *
     * @return string
     * @throws \LogicException
     * @throws \UnexpectedValueException
     */
    public static function baseDir(): string
    {
        // Detect the operating system
        self::operatingSystemIsWindows();

        $path = __FILE__;

        // To linux path format
        if (self::$operatingSystemIsWindows) {
            $path = self::pathWindowsToLinux($path);
        }

        // Delete the known project path suffix
        if ('/src/Config.php' !== mb_substr(self::$baseDir, -15, 15, Provider::CHARSET)) {
            throw new \UnexpectedValueException('Unexpected file path: ' . self::$baseDir);
        }
//
//        self::$baseDir = mb_substr(self::$baseDir, 0, -14, Provider::CHARSET);
//        self::$baseDirSet = true;
//        self::$baseDirReal = PathString\Utils::linuxToWindows(self::$baseDir);

        return self::$baseDir;
    }

    /**
     * Get base dir, windows format
     *
     * @return string
     */
    public static function baseDirReal(): string
    {
        if (self::$baseDirSet) {
            return self::$baseDirReal;
        }

        self::baseDir();

        return self::$baseDirReal;
    }

    /**
     * Is windows operating system?
     * Than we have another ::baseDirReal(), iOS and linux path are the same syntax
     *
     * @return bool
     * @throws \UnexpectedValueException
     */
    public static function operatingSystemIsWindows(): bool
    {
        if (self::$operatingSystemIsWindowsIsSet) {
            return self::$operatingSystemIsWindows;
        }

        self::$operatingSystemIsWindows = ('windows' == mb_strtolower(\PHP_OS_FAMILY, self::CHARSET_UTF8));
        if (self::$operatingSystemIsWindows && '\\' != \DIRECTORY_SEPARATOR) {
            throw new \UnexpectedValueException('\\PHP_OS_FAMILY is "windows" (lower case), but'
                . ' \\DIRECTORY_SEPARATOR is not ' . var_export('\\', true) . ', but '
                . var_export(\DIRECTORY_SEPARATOR, true)
            );
        }

        self::$operatingSystemIsWindowsIsSet = true;

        return self::$operatingSystemIsWindows;
    }

    /**
     * Convert windows to linux path
     *
     * @param string $path
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function pathWindowsToLinux(string $path): string
    {
        // Must be absolute path
        if ('' == $path) {
            throw new \InvalidArgumentException('$path must not be empty');
        }

        // We need no convert, if $path not contains backslash
        if (false === mb_strpos($path, '\\', 0, self::CHARSET_UTF8)) {
            return $path;
        }

        // Convert
        $path = preg_replace('/\\\\/iu', '/', $path);
        if (':/' === mb_substr($path, 1, 2, self::CHARSET_UTF8)) {
            $path = preg_replace_callback('/^([a-z]):\//iu', function ($match) {
                return '/' . mb_strtolower($match[1], self::CHARSET_UTF8) . '/';
            }, $path);
        }

        return $path;
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
