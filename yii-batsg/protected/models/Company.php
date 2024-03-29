<?php

/**
 * This is the model class for table "tbl_company".
 *
 * The followings are the available columns in table 'tbl_company':
 * @property integer $id
 * @property string $name
 * @property string $address
 *
 * The followings are the available model relations:
 * @property Employee[] $employees
 */
class Company extends BaseModel
{
  /**
   * Returns the static model of the specified AR class.
   * @return Company the static model class
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName()
  {
    return 'tbl_company';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('name', 'required'),
      array('address', 'safe'),
      // The following rule is used by search().
      // Please remove those attributes that should not be searched.
      array('id, name, address', 'safe', 'on'=>'search'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations()
  {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
      'employees' => array(self::HAS_MANY, 'Employee', 'company_id'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id' => 'ID',
      'name' => Y::t('name'),
      'address' => Y::t('address'),
    );
  }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
   */
  public function search()
  {
    // Warning: Please modify the following code to remove attributes that
    // should not be searched.

    $criteria=new CDbCriteria;

    $criteria->compare('id',$this->id);
    $criteria->compare('name',$this->name,true);
    $criteria->compare('address',$this->address,true);

    return new CActiveDataProvider(get_class($this), array(
      'criteria'=>$criteria,
    ));
  }
}
?>