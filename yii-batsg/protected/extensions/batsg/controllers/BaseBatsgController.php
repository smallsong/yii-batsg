<?php
/**
 * Controller that deal with BaseBatsgModel
 */
class BaseBatsgController extends BaseController
{
  /**
   * Create data provider model from the URL parameter.
   * This will get only data that has not been deleted.
   * @param string $modelClassName
   * @param string $dataStatusCondition Default to '<> 9' (not deleted record). NULL to not set data_status.
   * @return CActiveRecord
   */
  protected function dataProviderModel($modelClassName, $dataStatusCondition = '<> 9')
  {
    $model = new $modelClassName('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_REQUEST[$modelClassName])) {
      $model->attributes = $_REQUEST[$modelClassName];
    }
    try {
      if ($dataStatusCondition !== NULL) {
        $model->data_status = $dataStatusCondition;
      }
    } catch (Exception $e) {
      // Catch exception when data_status is not defined (in a view, for example).
    }
    return $model;
  }

  /**
   * Update a model from form.
   * @param string $modelClassName
   * @param BaseBatsgModel[] $hashedModelList
   * @param string[] $modelArr
   * @return BaseBatsgModel Return the model. If a new model (not exist in DB) is deleted, return NULL.
   */
  protected function updateModelFromForm($modelClassName, &$hashedModelList, $modelArr)
  {
    $model = NULL;
    // Create model object.
    // If model exists in $hashedModelList, use it
    if (isset($modelArr['id']) && $modelArr['id'] && isset($hashedModelList[$modelArr['id']])) {
      // Model exists in DB. Get it from model list.
      $model = $hashedModelList[$modelArr['id']];
    } else if (!isset($modelArr['data_status']) || $modelArr['data_status'] <> BaseBatsgModel::DATA_STATUS_DELETE) {
      // Else create new model object.
      $model = new $modelClassName();
      $hashedModelList[] = $model;
    }
    // Assign value from form to the model.
    if ($model) {
      $model->massiveAssign($model, $modelArr);
      $model->setEmptyStringToNull();
    }
    return $model;
  }
}
?>