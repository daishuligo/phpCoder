<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/3/24
 * Time: 17:11
 */

namespace app\code\controller;

use think\Db;

class IndexController extends BaseController
{
    public function index(){
        $table = $this->request->param('table');
        $sql = "show tables";
        $tableList = Db::query($sql);
        $tableList = array_column($tableList,'Tables_in_'.config('database.database'));
        $this->assign('tableList',$tableList);
        $this->assign('verify',config('verify.'));

        if(in_array($table,$tableList)){
            $res = $this->getTableFields($table);
            if($res['status']){
                $this->assign('fields',$res['data']);
            }else{
                $this->assign('fields',[]);
            }
        }

        return $this->fetch();
    }

    public function getFields(){
        $table = $this->request->param('table_name');
        if(!$table){
            $this->result([],0,'数据表不能为空','json');
        }

        $res = $this->getTableFields($table);
        if(!$res['status']){
            $this->result([],0,$res['msg'],'json');
        }


        $this->result($res['data'],1,'获取数据表字段成功','json');
    }
}