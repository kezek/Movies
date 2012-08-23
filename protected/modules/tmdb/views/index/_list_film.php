<div class="row">
   <span class="film-name"><?php echo $data->tmdb_name ?></span>     
   <?php
   if ($user_id = Yii::app()->user->id):

	  /** checks if the user has selected the film
	   * @return bool
	   */
	  $film_exists = UsersDirectorsFilms::model()->exists("user_id=$user_id AND film_id=$data->tmdb_id");
	  ?>
	  <?php if ($film_exists): ?>
	     <span class="film-added film-status">added</span>
		 <?php
	  else:
		 $this->renderPartial('tmdb.views.index._add_film', array('data' => $data));
	  endif;
	  ?>
   <?php
   else:
	  //if the user isnt logged in
	  $this->renderPartial('tmdb.views.index._add_film', array('data' => $data));
   endif;
   ?>
</div>