<?php

class IndexController extends CoreController
{

    public function init()
    {
        parent::init();
    }
    
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionSearch()
    {
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile(Yii::app()->getAssetManager()->publish($this->module->basePath . '/assets/css/tmdb.css'));
        $cs->registerScriptFile(Yii::app()->getAssetManager()->publish($this->module->basePath . '/assets/js/tmdb.js'));

        $model = new Directors('search');            
        $model->onSearch = array($this->getChache(),'cacheDirectors');             
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Directors']))
            $model->attributes = $_GET['Directors'];

        $this->render('search', array(
            'model' => $model,
        ));
    }

    /**
     * API method 
     */
    public function actionGetDirector()
    {
        header('Content-type: text/x-json');
        $model = Directors::model()->findByPk(Yii::app()->request->getParam('id'));
        echo CJSON::encode($model);
    }

    /**
     * @todo CURLManager (so that it takes a param) 
     */
    public function actionListFilms()
    {
        $this->layout = 'ajax';
        $tmdb_id = Yii::app()->request->getPost('tmdb_id');

        $dataProvider = new CActiveDataProvider('Films', array(
                    'criteria' => array(
                        'condition' => "tmdb_director_id = $tmdb_id",
                    )
                ));

        $this->render('list_films', array('dataProvider' => $dataProvider));
    }

    /**
     * 
     */
    public function actionAjax()
    {
        $request = Yii::app()->request;


        if ($request->isAjaxRequest):
            $response = array();
            //we initially assume there is no error
            $response['error'] = 0;
            if ($request->getPost('tmdb_id')):
                if ($user_id = Yii::app()->user->id):
                    $new_rel = new UsersDirectorsFilms;
                    $new_rel->user_id = Yii::app()->user->id;
                    $new_rel->director_id = $request->getPost('director_id');
                    $new_rel->film_id = $request->getPost('tmdb_id');
                    try {
                        $new_rel->save();
                    } catch (Exception $e) {
                        if ($e->getCode()) {
                            $response['error'] = 1;
                            $response['message'] = 'Movie already added';
                        }
                    }
                else:
                    $response['error'] = 1;
                    $response['message'] = 'You must be logged in to perform this action';
                endif;
            else:
                //tmdb_id is null
                $response['error'] = 1;
                $response['message'] = 'TMDB ID is NULL';
            endif;
        else:
            //NOT an AJAX request
            $request->redirect('search');
        endif;

        echo CJSON::encode($response);
    }

}