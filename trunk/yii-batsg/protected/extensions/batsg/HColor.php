<?php
class HColor
{
  const RGB_INDEX_RED = 0;
  const RGB_INDEX_GREEN = 1;
  const RGB_INDEX_BLUE = 2;

  /**
   * Generate random number in hex (include #).
   * @return string
   */
  public static function generateRandomColorHex()
  {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
  }

  /**
   * Generate random number in rgb.
   * @return int[3]
   */
  public static function generateRandomColorRgb()
  {
    return array(mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
  }

  /**
   * Remove sharp if exists.
   * @param string $hexColor
   * @return string
   */
  public static function removeSharpOfHexColor($hexColor)
  {
    if ($hexColor[self::RGB_INDEX_RED] == '#') {
      $hexColor = substr($hexColor, 1);
    }
    return $hexColor;
  }

  /**
   * Convert hex color (including # or not) to rgb color.
   * @param string $hexColor May contain sharp or not.
   * @return int[3]
   */
  public static function convertHexToRgb($hexColor)
  {
    $hexColor = self::removeSharpOfHexColor($hexColor);
    return array(
        hexdec(substr($hexColor,0,2)),
        hexdec(substr($hexColor,2,2)),
        hexdec(substr($hexColor,4,2))
    );
  }

  /**
   * Convert rgb color to hex color (with #).
   * @param int[3] $rgbColor
   * @return string
   */
  public static function convertRgbToHex($rgbColor)
  {
    return '#' . dechex($rgbColor[self::RGB_INDEX_RED]) . dechex($rgbColor[self::RGB_INDEX_GREEN]) . dechex($rgbColor[self::RGB_INDEX_BLUE]);
  }

  /**
   * Convert $color to (r, g, b) if it is a hex.
   * @param mixed $color Hex color (including # or not) or (r, g, b).
   * @return int[3]
   */
  public static function getRgb($color)
  {
    if (is_string($color)) {
      $color = self::convertHexToRgb($color);
    }
    return $color;
  }

  /**
   * Calculate color brightness.
   * @param mixed $color A hex color (including # or not) or (r, g, b) color.
   * @return int
   */
  public static function colorBrightness($color)
  {
    $color = self::getRgb($color);
    $brightness = (($color[self::RGB_INDEX_RED] * 299) + ($color[self::RGB_INDEX_GREEN] * 587) + ($color[self::RGB_INDEX_BLUE] * 114)) / 1000;
    return $brightness;
  }

  /**
   * Check if a color is light color.
   * @param mixed $color A hex color (including # or not) or (r, g, b) color.
   * @return boolean TRUE if it is a light color.
   */
  public static function isLightColor($color)
  {
    return self::colorBrightness($color) > 130;
  }

  /**
   * Check if a color is dark color.
   * @param mixed $color A hex color (including # or not) or (r, g, b) color.
   * @return boolean TRUE if it is a dark color.
   */
  public static function isDarkColor($color)
  {
    return !self::isLightColor($color);
  }

  /**
   * Check if two colors are high contrast.
   * Reference: http://www.w3.org/WAI/ER/WD-AERT/#color-contrast
   * @param mixed $color1 Hex color (including # or not) or (r, g, b).
   * @param mixed $color2 Hex color (including # or not) or (r, g, b).
   * @return boolean TRUE if two colors are high contrast.
   */
  public static function isHighContrast($color1, $color2)
  {
    $color1 = self::getRgb($color1);
    $color2 = self::getRgb($color2);
    $brightnessDifference = self::colorBrightness($color1) - self::colorBrightness($color2);
    $colorDifferece =
      (max($color1[self::RGB_INDEX_RED], $color2[self::RGB_INDEX_RED]) - min($color1[self::RGB_INDEX_RED], $color2[self::RGB_INDEX_RED])) +
      (max($color1[self::RGB_INDEX_GREEN], $color2[self::RGB_INDEX_GREEN]) - min($color1[self::RGB_INDEX_GREEN], $color2[self::RGB_INDEX_GREEN])) +
      (max($color1[self::RGB_INDEX_BLUE], $color2[self::RGB_INDEX_BLUE]) - min($color1[self::RGB_INDEX_BLUE], $color2[self::RGB_INDEX_BLUE]));
    return abs($brightnessDifference) > 125 && abs($colorDifferece) > 500;
  }
}
?>