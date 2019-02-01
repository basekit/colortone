<?php
namespace ColorTone;

use ColorWorks\Formats\Hex;
use ColorWorks\Formats\RGB;

class ColorTone
{
    // Multipliers lifted from https://bit.ly/2E4NjQZ
    const RED_MULTIPLIER = 299;
    const GREEN_MULTIPLIER = 587;
    const BLUE_MULTIPLIER = 114;

    const MIDPOINT = 255 / 2;

    public function generatePalette(array $swatch): array
    {
        $candidateColors = [];
        foreach ($swatch as $color) {
            $candidateColors[] = [
                'lightness' => $this->getLightness($color),
                'vibrancyScore' => $this->getVibrancyScore($color),
            ];
        }

        return [
            'light' => $this->getBestLightColor($swatch, $candidateColors),
            'dark' => $this->getBestDarkColor($swatch, $candidateColors),
            'vibrant' => $this->getBestVibrantColor($swatch, $candidateColors),
        ];
    }

    private function getBestVibrantColor(array $swatch, array $candidateColors): string
    {
        $candidates = array_map(function ($c) { return $c['vibrancyScore']; }, $candidateColors);
        $index = array_search(max($candidates), $candidates);
        return $swatch[$index];
    }

    private function getBestLightColor(array $swatch, array $candidateColors): string
    {
        $candidates = array_map(function ($c) { return $c['lightness']; }, $candidateColors);
        $index = array_search(max($candidates), $candidates);
        return $swatch[$index];
    }

    private function getBestDarkColor(array $swatch, array $candidateColors): string
    {
        $candidates = array_map(function ($c) { return $c['lightness']; }, $candidateColors);
        $index = array_search(min($candidates), $candidates);
        return $swatch[$index];
    }

    private function getVibrancyScore(string $color)
    {
        $hex = Hex::fromString($color);
        $hsl = $hex->toHSL();
        $l = $hsl->lightness;
        $s = $hsl->saturation;

        return ((min($l, (100 - $l)) * 2) + $s) / 2;
    }

    private function getLightness(string $color): float
    {
        $hex = Hex::fromString($color);
        $rgb = $hex->toRGB();

        $sum = array_sum(
            [
                $this->red($rgb),
                $this->green($rgb),
                $this->blue($rgb),
            ]
        );

        return $sum / 1000;
    }

    private function red(RGB $color): int
    {
        return $color->getRed() * self::RED_MULTIPLIER;
    }

    private function green(RGB $color): int
    {
        return $color->getGreen() * self::GREEN_MULTIPLIER;
    }

    private function blue(RGB $color): int
    {
        return $color->getBlue() * self::BLUE_MULTIPLIER;
    }
}
