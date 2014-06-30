<?php
Yii::import('application.vendor.PHPExcel.Classes.PHPExcel');

/**
 * Helper to access PHPExcel (http://phpexcel.codeplex.com/).
 * To use this, should modify PHPExcel_Autoloader::Register() as below
 * <code>
 * public static function Register() {
 *   return spl_autoload_register(array('PHPExcel_Autoloader', 'Load'), false, true);
 * }
 * </code>
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

  /**
   * Get value of a work sheet as two dimension array.
   * @param string[][] $sheet
   */
  public static function toArray($sheet)
  {
    return $sheet->toArray(null,true,true,true);
  }
}
?>