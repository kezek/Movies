<?php

/**
 * This is the model class for table "films".
 *
 * The followings are the available columns in table 'films':
 * @property integer $id
 * @property integer $tmdb_id
 * @property integer $tmdb_director_id
 * @property string $tmdb_name
 * @property string $tmdb_url
 * @property string $tmdb_released
 * @property string $tmdb_homepage
 * @property string $tmdb_trailer
 */
class Films extends CActiveRecord
{

   /**
	* Returns the static model of the specified AR class.
	* @param string $className active record class name.
	* @return Films the static model class
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
	  return 'films';
   }

   /**
	* @return array validation rules for model attributes.
	*/
   public function rules()
   {
	  // NOTE: you should only define rules for those attributes that
	  // will receive user inputs.
	  return array(
		  array('tmdb_id, tmdb_name,tmdb_director_id', 'required'),
		  array('tmdb_id,tmdb_director_id', 'numerical', 'integerOnly' => true),
		  array('tmdb_name, tmdb_url, tmdb_homepage, tmdb_trailer', 'length', 'max' => 255),
		  array('tmdb_released', 'safe'),
		  // The following rule is used by search().
		  // Please remove those attributes that should not be searched.
		  array('id, tmdb_director_id, tmdb_id, tmdb_name, tmdb_url, tmdb_released, tmdb_homepage, tmdb_trailer', 'safe', 'on' => 'search'),
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
		  'tmdb_id' => 'Tmdb',
		  'tmdb_name' => 'Tmdb Name',
		  'tmdb_url' => 'Tmdb Url',
		  'tmdb_released' => 'Tmdb Released',
		  'tmdb_homepage' => 'Tmdb Homepage',
		  'tmdb_trailer' => 'Tmdb Trailer',
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
	  $criteria->compare('tmdb_id', $this->tmdb_id);
	  $criteria->compare('tmdb_name', $this->tmdb_name, true);
	  $criteria->compare('tmdb_url', $this->tmdb_url, true);
	  $criteria->compare('tmdb_released', $this->tmdb_released, true);
	  $criteria->compare('tmdb_homepage', $this->tmdb_homepage, true);
	  $criteria->compare('tmdb_trailer', $this->tmdb_trailer, true);

	  return new CActiveDataProvider($this, array(
				  'criteria' => $criteria,
			  ));
   }

   public function cacheSearchResults($filmography, $director_id)
   {
	  foreach ($filmography as $film):
		 $new_film = new Films;
		 $new_film->tmdb_id = $film->id;
		 $new_film->tmdb_director_id = $director_id;
		 $new_film->tmdb_name = $film->name;
		 if (isset($film->url))
		 {
			$new_film->tmdb_url = $film->url;
		 }
		 if (isset($film->release))
		 {
			$new_film->tmdb_released = $film->release;
		 }
		 if (isset($film->homepage))
		 {
			$new_film->tmdb_homepage = $film->homepage;
		 }
		 if (isset($film->trailer))
		 {
			$new_film->tmdb_trailer = $film->trailer;
		 }
		 try
		 {
			$new_film->save();
		 } catch (Exception $e)
		 {
			Yii::log($e->getMessage());
		 }
	  endforeach;
   }
   


}

   function test(){
   fb('test init.php');
}