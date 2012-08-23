<?php	 
	  $this->widget('zii.widgets.TMDbListView', array(
		  //'id' => 'films-listing',
		  'loadingCssClass' => 'film-list',
		  'dataProvider' => $dataProvider,		
		  'enablePagination' => false,
		  'enableSorting' => false,
		  'summaryText' => false,
		  //'ajaxUpdate' => 'blabla',
		  'itemView' => '_list_film', // refers to the partial view named '_post'
		  'sortableAttributes' => array(
			  'tmdb_name',
		  ),		  
	  ));	  
?>
