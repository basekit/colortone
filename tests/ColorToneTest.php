<?php
namespace ColorToneTests;

use ColorTone\ColorTone;
use PHPUnit\Framework\TestCase;

class ColorToneTest extends TestCase
{
    private $colorTone;

    public function setUp()
    {
        $this->colorTone = new ColorTone;
    }

    /**
     * @test
     */
    public function generate()
    {
        $swatch = ['#FFFFFF', '#01B4F0', '#70C759', '#313748', '#888888'];
        $expected = [
            'light' => '#FFFFFF',
            'dark' => '#313748',
            'vibrant' => '#01B4F0',
        ];

        $result = $this->colorTone->generatePalette($swatch);
        $this->assertEquals($expected, $result);
    }
}
