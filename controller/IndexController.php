<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/3/24
 * Time: 17:11
 */

namespace app\code\controller;


class IndexController extends BaseController
{
    public function index(){
        return $this->fetch();
    }
}