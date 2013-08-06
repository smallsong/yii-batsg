<?php
Yii::import('application.vendors.*');
require_once "PHPExcel/Classes/PHPExcel.php";

/**
 * Helper to access PHPExcel (http://phpexcel.codeplex.com/).
 */
class HPhpExcel
{

  /**
   * @param string $file
   * @return PHPExcel_Worksheet
   */
  public static function openExcel($file) {
    $objPHPExcel = new PHPExcel(); // Load PHPExcel classes.

    $objReader = new PHPExcel_Reader_Excel2007();
    $objPHPExcel = $objReader->load($file);
    $sheet = $objPHPExcel->getActiveSheet();

    return $sheet;
  }

  /**
   * Get excel cell data.
   * @param PHPExcel_Worksheet $sheet
   * @param int $rowIndex Row number (base 1).
   * @param mixed $colIndex Column name (string, 'A' or 'AB' for example) or column number (base 0).
   * @return string
   */
  public static function getCell($sheet, $rowIndex, $colIndex) {
    $value = is_numeric($colIndex) ?
        $sheet->getCellByColumnAndRow($colIndex, $rowIndex) :
        $sheet->getCell("$colIndex$rowIndex");
    return trim($value);
  }
}
?>