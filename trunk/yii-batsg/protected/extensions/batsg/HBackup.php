<?php
/**
 * Utility function for backup and migration.
 */
class HBackup {

  /**
   * The marker at the first column of the CSV row to announce
   * that this is the start of a table (with the table name).
   * @var string
   */
  const TABLE_MARKER = '*';

  /**
   * For internal use in the class.
   * Index of element in a array that keeps the model object.
   * @var string
   */
  const IDX_MODEL = 'model';

  /**
   * For internal use in the class.
   * Index of element in a array that keeps the column index in an array.
   * @var string
   */
  const IDX_COLUMN_INDEX = 'columnIndex';

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
      // Write table name.
      fputcsv($handle, array(self::TABLE_MARKER, $modelClassName));
      // Write data.
      self::appendTableToCsv($modelClassName, $handle);
    }

    // Close output file.
    fclose($handle);
  }


  /**
   * Export data of specified table to csv file.
   *
   * @param string $modelClassName Name of model class to be backed up.
   * @param string $outputFileName
   */
  public static function exportTableToCsv($modelClassName, $outputFileName) {
    exportDbToCsv(array($modelClassName), $outputFileName);
  }

  /**
   * Append table data to the CSV file.
   * <p>
   * The first row is the table column names.
   * Follow is the records, each on one row.
   * @param string $modelClassName
   * @param resource $handle Output file handle.
   */
  private static function appendTableToCsv($modelClassName, $handle)
  {
    // Get model object.
    $model = new $modelClassName;
    // Get array of attributes.
    $attributes = $model->attributeNames();
    // Get all record from db.
    $records = $model->model()->findAll();
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

  /**
   * Load list of model from backed up csv file.
   * @param string $inputFileName The path to the CSV file.
   * @param string[] $fields Fields to be load into the model if specified. If is NULL, all columns are get.
   * @return array, each element is an array load from a CSV row, adding
   *     two elements 'model' => <the created model>,
   *     'columnIndex' => the column indexes.
   */
  public static function loadDbFromCsv($inputFileName, $fields = NULL) {
    $lines = array(); // Return result.

    // Open input file.
    $handle = fopen($inputFileName, 'r');

    // Read each line of csv.
    $attributes = NULL; // Columns to be loaded.
    $columnIndexes = NULL; // Column indexes in CSV columns.
    while (($data = fgetcsv($handle)) !== FALSE) {
      if ($data[0] === self::TABLE_MARKER) {
        // Process model class name line.
        $modelClassName = $data[1];
        $attributes = NULL; // Reset attribute names.
      } else if ($attributes === NULL) {
        $nColumns = count($data);
        // Process model attribute names line.
        $columnIndexes = self::parseColumnFromCsv($data);
        // Get all column if $fields is NULL, else get only specified fields.
        $attributes = $fields == NULL ? $data : $fields;
      } else if ($nColumns == count($data)) {
        // Process record data line.
        $model = new $modelClassName;
        foreach ($attributes as $attribute) {
          $model->$attribute = $data[$columnIndexes[$attribute]];
        }
        // Keep the model object and the column index information in $data.
        $data[self::IDX_MODEL] = $model;
        $data[self::IDX_COLUMN_INDEX] =& $columnIndexes;
        // Add $data to $lines.
        $lines[] = $data;
      }
    }

    // Close output file.
    fclose($handle);

    return $lines;
  }

  /**
   * Get the index of columns on a csv line.
   * @param string[] $csvLine
   * @return array Array[columnName] = index
   */
  public static function parseColumnFromCsv($csvLine)
  {
    $columns = array();
    foreach ($csvLine as $index => $columnName) {
      $columns[$columnName] = $index;
    }
    return $columns;
  }
}
?>