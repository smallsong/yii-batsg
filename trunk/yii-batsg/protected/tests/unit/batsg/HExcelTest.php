<?php
class HExcelTest extends CTestCase
{
  public function testColumnNum2Alpha()
  {
    $this->assertEquals('A', HExcel::columnNum2Alpha(0));
    $this->assertEquals('Z', HExcel::columnNum2Alpha(25));
    $this->assertEquals('AA', HExcel::columnNum2Alpha(26));
    $this->assertEquals('BA', HExcel::columnNum2Alpha(52));
  }

  public function testColumnAlpha2Num()
  {
    $this->assertEquals(0, HExcel::columnAlpha2Num('A'));
    $this->assertEquals(25, HExcel::columnAlpha2Num('Z'));
    $this->assertEquals(26, HExcel::columnAlpha2Num('AA'));
    $this->assertEquals(52, HExcel::columnAlpha2Num('BA'));
    $this->assertEquals(1, HExcel::columnAlpha2Num('A', 1));
  }
}?>