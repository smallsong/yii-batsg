<?php
class BaseController extends CController
{
	/**
   * Controller's specified language.
   * If specified, then this language will be used ignoring the user's selection.
   */
  public $fixedLanguage = NULL;
	
  /**
   * Override the init() method to call the setLanguage().
   */
  public function init()
  {
    parent::init();
    Y::setLanguage($this->fixedLanguage);
  }
    
  /**
   * Get the specified URL parameter.
   * If it is not set, $nullToValue will be returned.
   * @param string $paramName The parameter to be get.
   * @param mixed $nullToValue Value to return in case the parameter is not specified in the URL.
   * @param boolean $trim Trim the input value if set to TRUE
   * @return mixed
   */
  protected function getParam($paramName, $nullToValue = NULL, $trim = TRUE)
  {
    $value = isset($_REQUEST[$paramName]) ? $_REQUEST[$paramName] : $nullToValue;
    // Trim
    if ($trim) {
      if (is_array($value)) {
        foreach ($value as $key => $v) {
          $value[$key] = trim($v);
        }
      } else {
        $value = trim($value);
      }
    }
    return $value;
  }
}
?>