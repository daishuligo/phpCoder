<?php
/**
 * Created by PhpStorm.
 * User: INXX
 * Date: 2020/2/15
 * Time: 20:53
 */

namespace app\code\controller;


use think\App;
use think\Controller;
use think\Db;

class BaseController extends Controller
{
    function convertUnderline ( $str , $ucfirst = true)
    {
        $prefix = config('database.prefix');
        $str = substr($str,5);
        $str = ucwords(str_replace('_', ' ', $str));
        $str = str_replace(' ','',lcfirst($str));
        return $ucfirst ? ucfirst($str) : $str;
    }

    protected function getParam($type,$param){
        $data = [];
        if(!in_array($type,['get','post'])){
            $type = 'param';
        }
        foreach ($param as $v){
            $data[$v] = $this->request->$type($v) !== null ? $this->request->$type($v) : '';
        }

        return $data;
    }

    public function getTableFields($table){
        try{
            $fieldsList = Db::table($table)->getTableFields();
        }catch (\Exception $e){
            return [
                'status' => false,
                'msg'    => $e->getMessage(),
                'data'   => [],
            ];
        }

        return [
            'status' => true,
            'msg'    => 'ok',
            'data'   => $fieldsList,
        ];

    }

}