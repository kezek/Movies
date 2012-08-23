<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $create_time
 * @property string $last_login_time
 */
class Users extends CActiveRecord
{

   public $password_repeat;

   /**
	* Prepares create_time,  update_time before performing validation.
	*/
   protected function beforeValidate()
   {
	  if ($this->isNewRecord)
	  {
		 // set the create date, last updated date and the user doing the  creating
		 $this->create_time = $this->update_time = new CDbExpression("date('now')");		 
	  } else
	  {
		 //not a new record, so just set the last updated time and last 
		 //updated user id
		 $this->update_time = new CDbExpression("date('now')");		 
	  }

	  return parent::beforeValidate();
   }

   /**
	* Returns the static model of the specified AR class.
	* @param string $className active record class name.
	* @return Users the static model class
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
	  return 'users';
   }

   /**
	* @return array validation rules for model attributes.
	*/
   public function rules()
   {
	  // NOTE: you should only define rules for those attributes that
	  // will receive user inputs.
	  return array(
		  array('username, password, email', 'required'),
		  array('username, email', 'unique'),
		  array('username, password, email', 'length', 'max' => 128),
		  // The following rule is used by search().
		  // Please remove those attributes that should not be searched.
		  array('username, email', 'safe', 'on' => 'search'),
		  array('create_time, update_time', 'safe'),
		  array('password', 'compare'),
		  array('password_repeat', 'safe')
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
	  );
   }

   /**
	* @return array customized attribute labels (name=>label)
	*/
   public function attributeLabels()
   {
	  return array(
		  'id' => 'ID',
		  'username' => 'Username',
		  'password' => 'Password',
		  'email' => 'Email',
		  'last_login_time' => 'Last login time',
		  'create_time' => 'Create time',
		  'update_time' => 'Update time',
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

	  $criteria = new CDbCriteria;

	  $criteria->compare('username', $this->username, true);
	  $criteria->compare('email', $this->email, true);

	  return new CActiveDataProvider($this, array(
				  'criteria' => $criteria,
			  ));
   }

   protected function afterValidate()
   {
	  parent::afterValidate();
	  $this->password = md5($this->password);
   }

}