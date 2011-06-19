<?php
class SimpleBaseController extends BaseController
{
  /**
   * Process action create or update.
   * @param string $modelClassName
   * @param mixed $id the primary key
   * @param string $formView
   * @param boolean $saveDb Save DB or not. If $saveDb is TRUE, then the model will be saved.
   *        If $saveDb is FALSE, then the model will not be saved.
   *        If $saveDb is NULL, then the model will be saved if $_POST[$modelClassName] is set.
   * @param string $pkName primary key name. Default to "id".
   */
  protected function simpleCreateOrUpdate($modelClassName,
      $id,
      $formView,
      $successFlashMessage,
      $saveDb = NULL,
      $pkName = 'id')
  {
    // Create model to display in form.
    $model = $this->loadModel($modelClassName, $id);
  	    
    // Get model data from URL parameter if set.
    if(isset($_POST[$modelClassName]))
    {
      $model->attributes = $_POST[$modelClassName];
    }
    if ($saveDb == TRUE || ($saveDb === NULL && isset($_POST[$modelClassName]))) {
      // Redirect to view page if save successfully.
      if($this->simpleCreateOrUpdateSaveModel($model) {
          Y::setFlashSuccess($successFlashMessage);
          $this->redirect(array('view', $pkName => $model->$pkName));
      }
    }

    // Render form view (in the first time request or when data is invalid).
    $this->render($formView, array('model' => $model));
  }
  
  /**
   * Save a model object in the simpleCreateOrUpdate work flow.
   * Override this when neccessary.
   * @param CActiveRecord $model
   * @return boolean
   */
  protected function simpleCreateOrUpdateSaveModel($model)
  {
    return $model->save();
  }

  /**
   * @param string $modelClassName
   * @param mixed $id the primary key
   * @param string $formView
   * @param string $confirmView
   */
  protected function simpleConfirm($modelClassName, $id, $formView, $confirmView)
  {
    // Create model to display in form.
    $model = $this->loadModel($modelClassName, $id);
    
    // Get model data from URL parameter if set.
    if(isset($_POST[$modelClassName]))
    {
      $model->attributes = $_POST[$modelClassName];
      // Render confirm view if data is valid.
      if($this->simpleConfirmValidate($model) {
      	return $this->render($confirmView, array('model' => $model));
      }
    }

    // Render form view (incase of invalid data).
    $this->render($formView, array('model' => $model));
  }
  
  /**
   * Validate a model object in the simpleConfirm work flow.
   * Override this when neccessary.
   * @param CActiveRecord $model
   * @return boolean
   */
  protected function simpleConfirmValidate($model)
  {
    return $model->validate();
  }
  
  /**
   * Load existed/create new model.
   * Override this when neccessary.
   * @param string $modelClassName
   * @param mixed $id The object id. If id is NULL, then new model object is created.
   * @return BaseModel
   */
  protected function loadModel($modelClassName, $id)
  {
  	return BaseModel::loadModel($modelClassName, $id);
  }
}
?>