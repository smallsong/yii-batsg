<?php
/**
 * Manipulate 
 */
class HArray
{
  /**
   * Check if two arrays contain same value set.
   * @param array $arr1
   * @param array $arr2
   * @return boolean TRUE if two arrays contain same value set.
   */
  public static function equal($arr1, $arr2)
  {
    return !array_diff($arr1, $arr2) && !array_diff($arr2, $arr1);
  }
  
  /**
   * Flatten elements of a multi-dimension array.
   * @param mixed $arr Anything (normal object, or array).
   * @return array
   */
  public static function flatten($arr)
  {
    if (!is_array($arr)) {
      $arr = array($arr);
    }
    
    $result = array();
    foreach ($arr as $element) {
      // Merge element to $result if it is an array.
      if (is_array($element)) {
        $result = array_merge($result, self::flatten($element));
      } else {
        // Add element to $result.
        $result[] = $element;
      }
    }
    
    return $result;
  }
}
?>