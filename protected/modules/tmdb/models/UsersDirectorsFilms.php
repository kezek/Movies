<?php

/**
 * This is the model class for table "users_directors_films".
 *
 * The followings are the available columns in table 'users_directors_films':
 * @property integer $id
 * @property integer $user_id
 * @property integer $director_id
 * @property integer $film_id
 */
class UsersDirectorsFilms extends CActiveRecord
{

   /**
	* Returns the static model of the specified AR class.
	* @param string $className active record class name.
	* @return UsersDirectorsFilms the static model class
	*/
   public static function model($className = __CLASS__)
   {
	  return parent::model($className);
   }

   /**
	* @return string the associated database table name
	*/
   public function tableName()
   {
	  return 'users_directors_films';
   }

   /**
	* @return array validation rules for model attributes.
	*/
   public function rules()
   {
	  // NOTE: you should only define rules for those attributes that
	  // will receive user inputs.
	  return array(
		  array('user_id, director_id', 'required'),
		  array('user_id, director_id, film_id', 'numerical', 'integerOnly' => true),
		  // The following rule is used by search().
		  // Please remove those attributes that should not be searched.
		  array('id, user_id, director_id, film_id', 'safe', 'on' => 'search'),
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
		  'user_id'=> array(self::BELONGS_TO,'Users','id'),
		  'director' => array(self::BELONGS_TO,'Directors','director_id'),
		  'film'=>array(self::BELONGS_TO,'Films','film_id')
	  );
   }

   /**
	* @return array customized attribute labels (name=>label)
	*/
   public function attributeLabels()
   {
	  return array(
		  'id' => 'ID',
		  'user_id' => 'User',
		  'director_id' => 'Director',
		  'film_id' => 'Film',
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

	  $criteria->compare('id', $this->id);
	  $criteria->compare('user_id', $this->user_id);
	  $criteria->compare('director_id', $this->director_id);
	  $criteria->compare('film_id', $this->film_id);

	  return new CActiveDataProvider($this, array(
				  'criteria' => $criteria,
			  ));
   }


}