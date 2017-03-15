<?php
/**
 * Created by PhpStorm.
 * User: kayza_000
 * Date: 11.03.2017
 * Time: 14:49
 */

namespace controllers;


use core\Controller;
use models\ModelComments;
use models\ModelPost;

class ControllerPosts extends Controller
{

    public function actionAdd()
    {
        $this->registry['view']->generate('default', 'add_post');
    }

    public function actionPost()
    {
        if (empty($this->registry['url_action_data'][0])) {
            header('Location: ' . $this->registry['url'][1]);
            exit();
        }
        $model_post = new ModelPost();
        $model_comment = new ModelComments();
        $data['post'] = $model_post->getPost($this->registry['url_action_data'][0]);
        $data['post']['data'] = explode('-', $data['post']['data']);
        $data['comments'] = $model_comment->getComments($this->registry['url_action_data'][0]);
        $this->registry['view']->generate('default', 'post', $data);
    }

    public function actionSavePost()
    {
        $result = $this->validate($this->registry['request']->post);
        if (is_bool($result) && $result) {
            $model_post = new ModelPost();
            if ($model_post->postSave($this->registry['request']->post)) {
                header('Location: ' . $this->registry['url'][1]);
                exit();
            }
        } elseif (is_string($result)) {
            header('Location: ' . $this->registry['url'][1]);
            exit();
        } else {
            header('Location: ' . $this->registry['url'][3]);
            exit();
        }
    }
    
    public function actionSaveComment()
    {
        if(empty($this->registry['request']->post)) {
            header('Location: ' . $this->registry['url'][1]);
            return;
        }
        $reg = '/^[\w,\.\(\)\?\-\s]{2,}$/';
       $post = $this->registry['request']->post;
        if(preg_match_all($reg, $post['author']) &&(isset($post['comment']) && !empty($post['comment']))) {
            $post = array_values($post);
            $date = new \DateTime();
            $model = new ModelComments();
            if($model->commentSave($post)) {
                $url = $this->registry['url'][5].'/'.$this->registry['request']->post['post'];
                $this->registry['view']->ajaxRespond(0, '', array('url' => $url));
            }else{
               $this->registry['view']->ajaxRespond(1, 'not save', array());
            }
        } else{
            $this->registry['view']->ajaxRespond(1, 'not valid', array());
        }

    }

    private function validate($list)
    {
        $reg = '/^[\w,\.\(\)\?\-\s]{2,}$/';
        if (isset($list['post_name']) && isset($list['author']) && (isset($list['article']) && !empty($list['article']))) {
            if (preg_match_all($reg, $list['post_name']) && preg_match_all($reg, $list['author'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return 'not post object';
        }
    }
}