<?php
/**
 * Created by PhpStorm.
 * User: kayza_000
 * Date: 11.03.2017
 * Time: 14:49
 */

namespace controllers;


use core\App;
use core\Controller;
use models\ModelComments;
use models\ModelPost;

class ControllerPosts extends Controller
{

    public function actionAdd()
    {
        self::$view->generate('default', 'add_post');
    }

    public function actionPost()
    {
        if (empty($this->registry['url_action_data'][0])) {
            \Url::redirect(\Url::getLink(1));
        }
        $model_post = new ModelPost();
        $model_comment = new ModelComments();
        $data['post'] = $model_post->getPost($this->registry['url_action_data'][0]);
        $data['post']['data'] = explode('-', $data['post']['data']);
        $data['comments'] = $model_comment->getComments($this->registry['url_action_data'][0]);
        \MetaData::setTitle($data['post']['name']);
        self::$view->generate('default', 'post', $data);
    }

    public function actionSavePost()
    {
        $result = self::validate(App::getRequest()->post);
        if (is_bool($result) && $result) {
            $model_post = new ModelPost();
            if ($model_post->postSave(App::getRequest()->post)) {
                \Url::redirect(\Url::getLink(1));
            }
        } elseif (is_string($result)) {
            \Url::redirect(\Url::getLink(1));
        } else {
            \Url::redirect(\Url::getLink(3));
        }
    }
    
    public function actionSaveComment()
    {
        if (empty( App::getRequest()->post)) {
            \Url::redirect(\Url::getLink(1));
        }
        $reg = '/^[\w,\.\(\)\?\-\s]{2,}$/';
        $post = App::getRequest()->post;
        if (preg_match_all($reg, $post['author']) && (isset($post['comment']) && !empty($post['comment']))) {
            $post = array_values($post);
            $model = new ModelComments();
            if ($model->commentSave($post)) {
                $url = \Url::getLink(5) . '/' . App::getRequest()->post['post'];
                self::$view->ajaxRespond(0, '', array('url' => $url));
            } else {
                self::$view->ajaxRespond(1, 'not save', array());
            }
        } else {
            self::$view->ajaxRespond(1, 'not valid', array());
        }
    }

    private static function validate($list)
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