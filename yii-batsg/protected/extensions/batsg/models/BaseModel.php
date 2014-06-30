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
  public static function loadModel($modelClassName, $id = NULL)
  {
    if ($id != NULL) {
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

  /**
   * Log error of this model.
   * @param string $message
   */
  public function logError($message = NULL, $category='application')
  {
    if ($message) {
      Yii::log($message, 'error', $category);
    }
    Yii::log($this->tableName() . " " . print_r($this->attributes, TRUE), 'error', $category);
    Yii::log(print_r($this->getErrorMessages(), TRUE), 'error', $category);
  }

  /**
   * Create a hash of model list by a field value.
   * @param CActiveRecord $models
   * @param string $hashField Default by id.
   * @return array field value => model.
   */
  public static function hashModels($models, $hashField = 'id') {
    $hash = array();
    foreach ($models as $model) {
      $hash[$model->$hashField] = $model;
    }
    return $hash;
  }

  /**
   * Create a criteria for searching fields with OR operator (for example, searching name and name kana fields).
   * This is used to merge with the main criteria.
   * @param string $searchValue
   * @param string $table
   * @param string[] $fields
   * @return CDbCriteria
   */
  protected function dbCriteriaOr($searchValue, $fields, $table = 't', $partialMatch = TRUE)
  {
    $prefix = $table ? "{$table}." : NULL;
    $criteria = new CDbCriteria();
    foreach ($fields as $field) {
      $criteria->compare("$prefix$field", $searchValue, $partialMatch, 'OR');
    }
    return $criteria;
  }


  /**
   * @param mixed $fields String or string array. If NULL, all attributes are used.
   * @return string.
   */
  public function toString($fields = NULL)
  {
    if ($fields === NULL) {
      $fields = array_keys($this->attributes);
    }
    if (!is_array($fields)) {
      $info = array();
    }
    foreach ($fields as $field) {
      $info[] = "$field: {$this->$field}";
    }
    return get_class($this) . '(' . join(', ', $info) . ')';
  }

  /**
   * Add compare year/month to a db criterial.
   * @param CDbCriteria $criteria
   * @param string $column Column to be compared.
   * @param mixed $dateTime String or HDateTime Input date (or date time).
   */
  public static function addCompareYearMonth($criteria, $column, $dateTime)
  {
    if ($dateTime) {
      if (!$dateTime instanceof HDateTime) {
        $dateTime = preg_split("/[\/\-]+/", $dateTime);
        if (count($dateTime) > 1) {
          $dateTime = HDateTime::createFromString($dateTime[0] . '/' . $dateTime[1] . '/1');
        }
      }
      $dateTime = $dateTime->toString('Y-m');
      $criteria->compare("DATE_FORMAT($column, '%Y-%m')", $dateTime);
    }
  }
}
?>