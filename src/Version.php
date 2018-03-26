<?php

namespace Fawpami;

class Version
{
    /**
     * @param string $a
     * @param string $b
     * @return bool
     */
    public static function different($a, $b)
    {
        $vA = self::parse($a);
        $vB = self::parse($b);

        return $vA['major'] !== $vB['major'] ||
            $vA['minor'] !== $vB['minor'] ||
            $vA['patch'] !== $vB['patch'];
    }

    /**
     * @param string $version
     * @return array
     */
    private static function parse($version)
    {
        preg_match(
            '/^(?<major>\d+)\.(?<minor>\d+)\.(?<patch>\d+)$/',
            $version,
            $matches
        );

        return [
            'major' => (int)$matches['major'],
            'minor' => (int)$matches['minor'],
            'patch' => (int)$matches['patch']
        ];
    }

    /**
     * @param string $version
     * @return bool
     */
    public static function validate($version)
    {
        return (bool)preg_match('/^\d+\.\d+\.\d+$/', $version);
    }
}