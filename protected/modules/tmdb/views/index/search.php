<?php
/*
Yii::app()->clientScript->registerScript('dc', "
var current_row;   
$('#users-grid table tbody tr').live('click',function()
{
  console.log('click row');
   current_row = $(this).children(':nth-child(1)');	 
});	  

");

$this->breadcrumbs = array(
	'Directors' => array('index'),
	'Manage',
);
*/
$this->menu = array(
	array('label' => 'List Directors', 'url' => array('index')),
	array('label' => 'Create Directors', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('users-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>

<p>
   You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
   or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
   <?php
   $this->renderPartial('_search', array(
	   'model' => $model,
   ));
   ?>
</div><!-- search-form -->

<?php
/**
 * @see http://www.yiiframework.com/doc/api/1.1/CButtonColumn 
 */
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'users-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	//'selectionChanged' => 'function(id){tmdb.getTmdbId($.fn.yiiGridView.getSelection(id));}',
	'selectionChanged' => 'function (id) {new TMDb($.fn.yiiGridView.getSelection(id),current_row);}',
	'columns' => array(
		array(
			'name' => 'tmdb_name',
		),
		array(
			'class' => 'CButtonColumn',
			'template' => '{view}',
			'buttons' => array(
				'btnCVs' => array(
					'label' => 'See resumes',
					'url' => '"javascript:viewResumes(\"".$data->tmdb_name."\");"',
					//'imageUrl' => '/gammarh/assets/dad4ddbc/gridview/cvs.gif',
//						'click' => 'test()',
					'visible' => 'true',
				), //					
			),
			'template' => '{btnCVs}',
			'viewButtonOptions' => array("target" => "_blank"),			
		),		
	),
	'updateSelector' => '.films-list'
));
?>


