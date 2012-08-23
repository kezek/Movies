<?php

/**
 * Description of UsersSQLInit
 *
 * @author Andrei
 * @name UsersSQLInit
 * @for Altfactor.ro
 */
class UsersSQLInit
{
   public function __construct()
   {
	  $connection = Yii::app()->db;
	  if (!$connection->schema->getTable('users'))
		 $connection->createCommand()->createTable(
				 'users',
				  array(
					 'id' => 'pk',
				  'username' => 'string NOT NULL UNIQUE',
				  'password' => 'string NOT NULL',
				  'email' => 'string NOT NULL UNIQUE',
				  'last_login_time' => 'datetime',
					  'create_time' => 'datetime',
					  'update_time' => 'datetime'
				  )
		 );	  
   }

}

?>
