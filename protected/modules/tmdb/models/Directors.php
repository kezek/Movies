<?php

/**
 * This is the model class for table "directors".
 *
 * The followings are the available columns in table 'directors':
 * @property integer $id
 * @property integer $tmdb_id
 * @property string $tmdb_name
 * @property string $tmdb_url
 * @property string $tmdb_bio
 */
class Directors extends TMDbAbstract
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Directors the static model class
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
        return 'directors';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tmdb_id, tmdb_name, tmdb_url', 'required'),
//		  array('tmdb_id', 'numerical', 'integerOnly' => true),		  
            array('tmdb_name, tmdb_url, tmdb_bio', 'safe'),
            array('tmdb_id', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('tmdb_name', 'safe', 'on' => 'search'),
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
            'tmdb_bio' => 'Tmdb Bio',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        if ($this->tmdb_name && self::$tmdb):
            $this->_cacheSearchResults();
        endif;

        $event = new TMDbEvent($this);
        $event->setData('DATA');
        $this->onSearch($event);
        $criteria = new CDbCriteria;
        $criteria->compare('tmdb_name', $this->tmdb_name, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function onSearch($event)
    {
        $this->raiseEvent('onSearch', $event);
    }

    /**
     * Save to db the user search results 
     */
    protected function _cacheSearchResults()
    {
        $json_persons_result = self::$tmdb->searchPerson($this->tmdb_name);
        $results = json_decode($json_persons_result);
        //if we have results from the tmdb api
        if (count($results) > 1):
            foreach ($results as $person):

                //caching the director's filmography
                $filmography = $this->getFilteredFilmography($person->id);
                if (!empty($filmography)):
                    Films::model()->cacheSearchResults($filmography, $person->id);
                else:
                    continue;
                endif;

                //caching the director
                $new_dir = new Directors;
                $new_dir->tmdb_name = $person->name;
                $new_dir->tmdb_id = $person->id;
                $new_dir->tmdb_bio = $person->biography;
                $new_dir->tmdb_url = $person->url;

                try {
                    $new_dir->save();
                } catch (Exception $e) {
                    Yii::log($e->getMessage());
                }

            endforeach;
        endif;
    }

    public function getPerson($id)
    {
        $tmdb = new Tmdb();
        $person = $tmdb->getPerson($id);
        $result = json_decode($person);

        return $result[0];
    }

    /**
     * If empty we are not interested
     * @param type $id
     * @return type 
     */
    public function getFilmography($id)
    {
        $person = $this->getPerson($id);
        return $person->filmography;
    }

    /**
     * This will retun only the directed and written films of the persons id
     * @param int $id
     * @return array $filmography 
     */
    public function getFilteredFilmography($id)
    {
        $filmography = $this->getFilmography($id);
        foreach ($filmography as $key => $film):
            if ($film->job != 'Director') {
                unset($filmography[$key]);
            }
        endforeach;

        return $filmography;
    }

    /**
     * Accepts $director instance of Directors model or an ID (tmdb_id)
     * 
     * @return False if it didnt return any name     
     */
    public function getDirectorName($director)
    {
        //if $data isnt an instance of Director model
        if (($director instanceof Directors)):
            return $director->tmdb_name;
        else:
            //maybe we are sending the director_id AKA tmdb_id
            try {
                $director = $this->findByAttributes(array('tmdb_id' => $director));
                if (!$director):
                    Yii::log('invalid tmdb_id');
                    return false;
                else:
                    return $director->tmdb_name;
                endif;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        endif;

        return false;
    }

}