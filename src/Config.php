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
    const CHARSET_UTF8 = 'utf8';

    /**
     * Default directory path separator
     *
     * @var string
     */
    const DIRECTORY_SEPARATOR = '/';

    /**
     * Self file path suffix
     * Linux path format
     *
     * @var string
     */
    private const SELF_FILE_SUFFIX = '/src/Config.php';

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
     * Self file path suffix, length
     *
     * @var int
     */
    private static $selfFileSuffixLength = -1;

    /**
     * Get base dir
     *
     * @return string
     * @throws \LogicException
     * @throws \UnexpectedValueException
     */
    public static function baseDir(): string
    {
        if (self::$baseDirSet) {
            return self::$baseDir;
        }

        // Detect the operating system
        self::operatingSystemIsWindows();

        $path = __FILE__;
        $pathOrg = $path;

        // To linux path format
        if (self::$operatingSystemIsWindows) {
            $path = self::pathWindowsToLinux($path);
        }

        // Delete the known project path suffix
        if (self::$selfFileSuffixLength < 0) {
            self::$selfFileSuffixLength = mb_strlen(self::SELF_FILE_SUFFIX,
                self::CHARSET_UTF8
            );
        }

        if (mb_strlen($path, self::CHARSET_UTF8)
            <= self::$selfFileSuffixLength
        ) {
            throw new \UnexpectedValueException('Unexpected file'
                . ' path: ' . $pathOrg
            );
        } elseif (self::SELF_FILE_SUFFIX
            != mb_substr($path, 0 - self::$selfFileSuffixLength,
                self::$selfFileSuffixLength, self::CHARSET_UTF8
            )
        ) {
            throw new \UnexpectedValueException('Unexpected file'
                . ' path: ' . $pathOrg
            );
        }

        $path = mb_substr($path, 0, 0 - (self::$selfFileSuffixLength - 1),
            self::CHARSET_UTF8
        );
        $posVendor = mb_stripos($path, '/vendor/', 0, self::CHARSET_UTF8);
        if (false !== $posVendor) {
            $path = mb_substr($path, 0, $posVendor + 1, self::CHARSET_UTF8);
        }

        self::$baseDir = $path;
        self::$baseDirSet = true;
        self::$baseDirReal = self::$baseDir;
        if (self::$operatingSystemIsWindows) {
            self::$baseDirReal = self::pathLinuxToWindows(self::$baseDir);
        }

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
     * Convert linux to windows path
     *
     * @param string $path
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function pathLinuxToWindows(string $path): string
    {
        if ('' == $path) {
            throw new \InvalidArgumentException('$path must not be empty');
        }

        // We need no convert, if $path not contains backslash
        if (false === mb_strpos($path, '/', 0, self::CHARSET_UTF8)) {
            return $path;
        }

        $path = self::pathLinuxToWindowsConvertPrefix($path);
        $path = preg_replace('/\//iu', '\\', $path);

        return $path;
    }

    /**
     * Convert linux to windows path, convert prefix to windows drive letter, if possible
     *
     * @param string $path
     * @return string
     */
    protected static function pathLinuxToWindowsConvertPrefix(string $path): string
    {
        // Requirements:
        // - $path has 3 char prefix
        // - prefix starts and ends with "7"
        // - prefix middle is letter
        if ('' == $path) {
            return $path;
        } elseif (mb_strlen($path, self::CHARSET_UTF8) < 3) {
            return $path;
        } else if ('/' != mb_substr($path, 0, 1, self::CHARSET_UTF8)) {
            return $path;
        } else if ('/' != mb_substr($path, 2, 1, self::CHARSET_UTF8)) {
            return $path;
        }

        $letter = mb_substr($path, 1, 1, self::CHARSET_UTF8);
        if (!ctype_alpha($letter)) {
            return $path;
        }

        $letter = mb_strtoupper($letter, self::CHARSET_UTF8);

        return $letter . ':' . mb_substr($path, 2, null, self::CHARSET_UTF8);
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
}
