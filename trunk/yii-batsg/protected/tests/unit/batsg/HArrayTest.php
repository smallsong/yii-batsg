<?php
class HArrayTest extends CTestCase
{
  public function testEqual()
  {
    // int[]
    $this->assertTrue(HArray::equal(array(1, 2, 3), array(3, 2, 1)));
    // assoc array.
    $this->assertTrue(HArray::equal(
        array('mot' => 'one', 'hai' => 'two', 'ba' => 'three'),
        array('san' => 'three', 'ni' => 'two', 'ichi' => 'one')));
    $this->assertFalse(HArray::equal(array(1, 2, 3), array(3, 2, 4)));
  }
  
  public function testFlatten()
  {
    // Flatten empty array.
    $arr = HArray::flatten(array());
    $this->assertTrue(HArray::equal($arr, array()));
    // Flatten one element.
    $arr = HArray::flatten(1);
    $this->assertTrue(HArray::equal($arr, array(1)));
    // Flatten array element.
    $arr = HArray::flatten(array(2, 3));
    $this->assertTrue(HArray::equal($arr, array(2, 3)));
    // Flatten mixed.
    $arr = HArray::flatten(array(6, array(2, 3), array(4, 5)));
    $this->assertTrue(HArray::equal($arr, array(2, 3, 4, 5, 6)));
  }
  
}
?>