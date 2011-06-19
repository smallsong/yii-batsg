<?php
class BaseModel extends CActiveRecord
{
  /**
   * Returns the data model based on the primary key given.
   * If the data model is not found, an HTTP exception will be raised.
   * @param string $modelClassName
   * @param mixed $id the primary key of the model to be loaded
   * @return CActiveRecord
   */
  public static function loadModel($modelClassName, $id == NULL)
  {
    if ($id !== NULL) {
      $model = call_user_func(array($modelClassName, 'model'))->findByPk($id);
      if($model === null) {
        throw new CHttpException(404, 'The requested page does not exist.');
      }
    } else {
      $model = new $modelClassName;
    }
    return $model;
  }
  
  /**
   * Get all errors on this model.
   * @param string $attribute attribute name. Use null to retrieve errors for all attributes.
   * @return array errors for all attributes or the specified attribute. Empty array is returned if no error.
   */
  public function getErrorMessages($attribute = NULL)
  {
    if ($attribute === NULL) {
      $attribute = $this->attributeNames();
    }
    if (!is_array($attribute)) {
      $attribute = array($attribute);
    }
    $errors = array();
    foreach ($attribute as $attr) {
      if ($this->hasErrors($attr)) {
        $errors = array_merge($errors, array_values($this->getErrors($attr)));
      }
    }
    return $errors;
  }
}
?>