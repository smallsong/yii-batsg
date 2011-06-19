<?php
class HExcel
{
  /**
   * Convert an integer to a string of uppercase letters (A-Z, AA-ZZ, AAA-ZZZ, etc.)
   * @param int $n
   * @param string
   */
  public static function columnNum2Alpha($n)
  {
    for($r = ''; $n >= 0; $n = intval($n / 26) - 1) {
      $r = chr($n % 26 + 0x41) . $r;
    }
    return $r;
  }

  /**
   * Convert a string of uppercase letters to an integer.
   * @param string $a
   * @param int startIndex from 0 or 1
   * @return int
   */
  public static function columnAlpha2Num($a, $startIndex = 0)
  {
    $a = strtoupper($a);
    $l = strlen($a);
    $n = 0;
    for($i = 0; $i < $l; $i++)
    $n = $n*26 + ord($a[$i]) - 0x40;
    return $n - 1 + $startIndex;
  }
}
?>