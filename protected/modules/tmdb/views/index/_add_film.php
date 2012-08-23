<?php
//the film tmdb id
$tmdb_id = $data->tmdb_id;
?>

<span class="film-add film-status">
   <?php
   $_elem_id = 'add-film-' . $tmdb_id;
   echo CHtml::ajaxLink('add', array('ajax'), array(
	   'type' => 'POST',
	   'dataType' => 'json',
	   'data' => array('tmdb_id' => $tmdb_id, 'director_id' => $data->tmdb_director_id),
	   'success' => "function( data )
						   {
						   // handle return data						   						  
						   if (data.error) {
						    alert(data.message);
						   }
						   else 
							  {
								 $('#{$_elem_id}').hide();
							  }						   
						   }",
		   ), array('id' => $_elem_id, 'movie-id' => $tmdb_id)
   );
   ?>
</span>
