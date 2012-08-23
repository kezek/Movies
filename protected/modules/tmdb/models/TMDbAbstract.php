<?php

/**
 * Description of Abstract
 *
 * @author Andrei
 * @name Abstract
 * @for Altfactor.ro
 */
abstract class TMDbAbstract extends CActiveRecord
{

   protected static $tmdb;
   
   public function __construct($scenario = 'insert')
   {
	  
	  self::$tmdb = new TMDb();
	  parent::__construct($scenario);
   }    

}

?>
