<?php
/**
 * Alternative class of CHtml.
 *
 * @author thanh <umbalaconmeogia@gmail.com>
 */
class HHtml
{
  /**
   * Renders a radio button list for a model attribute.
   * This method is a wrapper of {@link CHtml::activeRadioButtonList}.
   * Please check {@link CHtml::activeRadioButtonList} for detailed information
   * about the parameters for this method.
   * @param CModel $model the data model
   * @param string $attribute the attribute
   * @param array $data value-label pairs used to generate the radio button list.
   * @param array $htmlOptions addtional HTML options.
   * @param boolean $translateData tranlsate $data value if set to TRUE.
   * @return string the generated radio button list
   */
  public static function activeRadioButtonList($model, $attribute, $data,
      $htmlOptions = array('separator' => ' ', 'labelOptions' => array('style' => 'display: inline; font-weight: normal;')),
      $translateData = TRUE)
  {
    if ($translateData) {
      $data = Y::translateArrayValue($data);
    }
    return CHtml::activeRadioButtonList($model, $attribute, $data, $htmlOptions);
  }

  /**
   * Renders a checkbox list for a model attribute.
   * This method is a wrapper of {@link CHtml::activeCheckBoxList}.
   * Please check {@link CHtml::activeCheckBoxList} for detailed information
   * about the parameters for this method.
   * @param CModel $model the data model
   * @param string $attribute the attribute
   * @param array $data value-label pairs used to generate the check box list.
   * @param array $htmlOptions addtional HTML options.
   * @param boolean $translateData tranlsate $data value if set to TRUE.
   * @return string the generated check box list
   */
  public static function activeCheckBoxList($model, $attribute, $data,
      $htmlOptions = array('separator' => ' ', 'labelOptions' => array('style' => 'display: inline; font-weight: normal;')),
      $translateData = TRUE)
  {
    if ($translateData) {
      $data = Y::translateArrayValue($data);
    }
    return CHtml::activeCheckBoxList($model, $attribute, $data, $htmlOptions);
  }

  /**
   * Generates a check box list.
   * This method is a wrapper of {@link CHtml::activeCheckBoxList}.
   * Please check {@link CHtml::activeCheckBoxList} for detailed information
   * about the parameters for this method.
   * @param string $name name of the check box list
   * @param mixed $select selection of the check boxes.
   * @param array $data value-label pairs used to generate the check box list.
   * @param array $htmlOptions addtional HTML options.
   * @param boolean $translateData tranlsate $data value if set to TRUE.
   * @return string the generated check box list
   */
  public static function checkBoxList($name, $select, $data,
      $htmlOptions = array('separator' => ' ', 'labelOptions' => array('style' => 'display: inline; font-weight: normal;')),
      $translateData = TRUE)
  {
    if ($translateData) {
      $data = Y::translateArrayValue($data);
    }
    return CHtml::checkBoxList($name, $select, $data, $htmlOptions);
  }

  /**
   * Get cycling value.
   * @param int $counter
   * @param array $values
   * @return mixed
   */
  public static function cycle(&$counter, $values = array('even', 'odd'))
  {
    $value = isset($values[$counter]) ? $values[$counter] : NULL;
    $counter = ($counter + 1) % count($values);
    return $value;
  }

  /**
   * Echo class="odd" or class="even"
   * @param int $counter
   * @param boolean $echo
   * @param array $values
   */
  public static function cycleClass(&$counter, $echo = TRUE, $values = array('even', 'odd'))
  {
    $cssClass = 'class="' . self::cycle($counter, $values) . '"';
    if ($echo) {
      echo $cssClass;
    }
    return $cssClass;
  }

  /**
   * Generate a link display as button.
   * See CHtml::link() for the parameters' detail.
   * @param string $text link body. This is changed to button tag.
   * @param mixed $url a URL or an action route that can be used to create a URL.
   * @param array $htmlOptions additional HTML attributes.
   * @return string the generated hyperlink
   */
  public static function buttonLink($text, $url='#',$htmlOptions = array())
  {
    if (!isset($htmlOptions['onlick'])) {
      $url = CHtml::normalizeUrl($url);
      $htmlOptions['onclick'] = "window.location='$url'";
    }
    return CHtml::button($text, $htmlOptions);
  }

  /**
   * Display hidden fields.
   * @param CActiveRecord $model
   * @param string $index
   * @param mixed $fields NULL, or string (fields name), or array of fieldNames.
   * @param array $htmlOptions
   */
  public static function showHiddenFields($model, $index = NULL, $fields = NULL, $htmlOptions = array())
  {
    if (!$fields) {
      $fields = array_keys($model->attributes);
    }
    if (!is_array($fields)) {
      $fields = array($fields);
    }
    foreach ($fields as $field) {
      $attribute = $index !== NULL ? "[$index]$field" : $field;
      // Add class to html options.
      $options = $htmlOptions;
      if (isset($options['class'])) {
        $options['class'] .= " $field";
      } else {
        $options['class'] = "$field";
      }
      echo CHtml::activeHiddenField($model, $attribute, $options) . "\n";
    }
  }
}
?>