<?php

/**
 * Created by PhpStorm.
 * User: kayza_000
 * Date: 10.03.2017
 * Time: 21:50
 */
namespace controllers;
use core\Controller;
use models\ModelComments;
use models\ModelPost;

class ControllerHome extends Controller
{
    public function actionIndex()
    {
        $model = new ModelPost();
        $data['all_post'] = $model->getPostAll();
        $data['popular'] = $model->popular(5);

        $this->registry['view']->generate('home', 'home', $data);
    }
    public function actionPage404()
    {

    }
}