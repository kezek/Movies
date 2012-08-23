<?php

class TMDbSQLInit
{

   public function __construct()
   {
	  $connection = Yii::app()->db;
	  if (!$connection->schema->getTable('directors'))
		 $connection->createCommand()->createTable(
				 'directors',
				  array(
					 'id' => 'pk',
				  'tmdb_id' => 'integer NOT NULL',
				  'tmdb_name' => 'string NOT NULL',
				  'tmdb_url' => 'string NOT NULL',
				  'tmdb_bio' => 'string')
		 );
	  
	  if (!$connection->schema->getTable('films'))
		 $connection->createCommand()->createTable(
				 'films',
				 array(
					 'id' => 'pk',
					 'tmdb_id' => 'integer NOT NULL UNIQUE',
					 'tmdb_director_id' => 'integer NOT NULL',
					 'tmdb_name' => 'string NOT NULL',
					 'tmdb_url' => 'string',
					 'tmdb_released' => 'datetime',
					 'tmdb_homepage' => 'string'					 
				 )
		);
	  
	  if (!$connection->schema->getTable('users_directors_films'))
		 $connection->createCommand()->createTable(
				 'users_directors_films',
				 array(
					 'id' => 'pk',
					 'user_id' => 'integer NOT NULL',
					 'director_id' => 'integer NOT NULL',
					 'film_id' => 'integer',
					 'UNIQUE(user_id,film_id)',
					 'FOREIGN KEY(user_id) REFERENCES users(id)',
					 'FOREIGN KEY(director_id) REFERENCES directors(tmdb_id)',
					 'FOREIGN KEY(film_id) REFERENCES films(tmdb_id)',
				 )
	   );
   }

}

?>
