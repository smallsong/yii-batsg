<?php
class HFile
{
  /**
   * Remove directory (recursively).
   * @param string $directory
   * @param boolean $checkDirExistance If TRUE, throw error if $directory does not exist.
   * @throw InvalidArgumentException if $checkDirExistance is TRUE and the directory does not exist.
   */
  public static function rmdir($directory, $checkDirExistance = TRUE)
  {
    if (is_dir($directory)) {
      self::removeDirRecursively($directory);
    } else {
      if ($checkDirExistance) {
        throw new InvalidArgumentException("Directory $directory does not exist.");
      }
    }
  }

  private static function removeDirRecursively($directory)
  {
    // Remove files and sub-directories.
    foreach (scandir($directory) as $file) {
      if ($file != '.' && $file != '..') {
        $path = "$directory/$file";
        if (is_file($path)) {
          unlink($path);
        } else {
          self::removeDirRecursively($path);
        }
      }
    }
    Yii::log("remove {$directory}");
    rmdir($directory);
  }

  /**
   * List files inside specified path (exclude . and ..).
   * @param string $directory
   * @return array of filename => path
   */
  public static function listFile($directory)
  {
    $result = array();
    foreach (scandir($directory) as $file) {
      if ($file != '.' && $file != '..') {
        $path = "$directory/$file";
        if (is_file($path)) {
          $result[$file] = $path;
        }
      }
    }
    return $result;
  }

  /**
   * List directories inside specified path (exclude . and ..).
   * @param string $directory
   * @return array of dirname => path
   */
  public static function listDir($directory)
  {
    $result = array();
    foreach (scandir($directory) as $file) {
      if ($file != '.' && $file != '..') {
        $path = "$directory/$file";
        if (is_dir($path)) {
          $result[$file] = $path;
        }
      }
    }
    return $result;
  }

  /**
   * Get the file extension.
   * @param string $path Path to the file name.
   * @return string File extension (after the last dot .)
   *         or NULL if there is no extension.
   */
  public static function fileExtension($path)
  {
    $pathInfo = pathinfo($path);
    return isset($pathInfo['extension']) ? $pathInfo['extension'] : NULL;
  }

  /**
   * Get the file basename.
   * @param string $path Path to the file name.
   * @return string File basename (before the last dot .)
   */
  public static function fileFileName($path)
  {
    $pathInfo = pathinfo($path);
    return $pathInfo['filename'];
  }
}
?>
