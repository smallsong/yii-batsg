<?php
/**
 * Utility function for backup and migration.
 */
class HBackup {
  const TABLE_MARKER = '*';

  /**
   * Export data of specified tables to csv file.
   *
   * @param string[] $modelClassNames Name of model classes to be backed up.
   * @param string $outputFileName
   */
  public static function exportDbToCsv($modelClassNames, $outputFileName)
  {
    // Open output file.
    $handle = fopen($outputFileName, 'w');
    
    // Export each table.
    foreach ($modelClassNames as $modelClassName) {
      self::exportTableToCsv($modelClassName, $handle);
    }
    
    // Close output file.
    fclose($handle);
  }
  
  /**
   * @param string $modelClassName
   * @param resource $handle Output file handle.
   */
  private static function exportTableToCsv($modelClassName, $handle)
  {
    // Get model object.
    $model = new $modelClassName;
    // Get array of attributes.
    $attributes = $model->attributeNames();
    // Get all record from db.
    $records = $model->model()->findAll();
    // Write table name.
    fputcsv($handle, array(self::TABLE_MARKER, $modelClassName));
    // Write column name.
    fputcsv($handle, $attributes);
    // Write records.
    foreach ($records as $record) {
      // Put record data to an array.
      $data = array();
      foreach ($attributes as $attribute) {
        $data[] = $record->$attribute;
      }
      fputcsv($handle, $data);
    }
  }
  
  /**
   * Import data from csv file created by exportDbToCsv().
   *
   * @param string $inputFileName
   */
  public static function importDbFromCsv($inputFileName)
  {
    // Open input file.
    $handle = fopen($inputFileName, 'r');

    // Read each line of csv.
    $attributes = NULL;
    while (($data = fgetcsv($handle)) !== FALSE) {
      if ($data[0] === self::TABLE_MARKER) {
        // Process model class name line.
        $modelClassName = $data[1];
        $attributes = NULL; // Reset attribute names.
      } else if ($attributes === NULL) {
        // Process model attribute names line.
        $attributes = $data;
      } else {
        // Process record data line.
        $model = new $modelClassName;
        foreach ($attributes as $index => $attribute) {
          $model->$attribute = $data[$index];
        }
        // Save record.
        if (!$model->save()) {
          throw new Exception("Error saving $modelClassName $model");
        }
      }
    }
    
    // Close output file.
    fclose($handle);
  }
}
?>