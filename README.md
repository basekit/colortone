![ColorTone](/../master/readme-header.png?raw=true)

# Installation

Through composer:

```bash
composer require basekit/colortone
```

# Usage

```php
$swatch = ['#FFFFFF', '#01B4F0', '#70C759', '#313748', '#888888'];
$colorTone = new \ColorTone\ColorTone;
$palette = $colorTone->generatePalette($swatch);

var_dump($palette);
// array(3) {
//   ["light"]=>
//   string(7) "#FFFFFF"
//   ["dark"]=>
//   string(7) "#313748"
//   ["vibrant"]=>
//   string(7) "#01B4F0"
// }
```
