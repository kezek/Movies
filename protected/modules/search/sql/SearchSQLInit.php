<?php
class SearchSQLInit
{

    public function __construct()
    {
        $connection = Yii::app()->db;
        if (!$connection->schema->getTable('search'))
            $connection->createCommand()->createTable(
                    'search', array(
                'id' => 'pk',                
                'term' => 'string NOT NULL',              
                    )
            );
    }

}
