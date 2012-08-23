<?php

Yii::import('zii.widgets.CListView');
class TMDbListView extends CListView {
   
   public function init()
	{
		if($this->itemView===null)
			throw new CException(Yii::t('zii','The property "itemView" cannot be empty.'));
		parent::init();

		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='list-view';

		if($this->baseScriptUrl===null)
			$this->baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/listview';

		if($this->cssFile!==false)
		{
			if($this->cssFile===null)
				$this->cssFile=$this->baseScriptUrl.'/styles.css';
			Yii::app()->getClientScript()->registerCssFile($this->cssFile);
		}
	}
   
   public function renderKeys()
   {
	  return '';
   }
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
