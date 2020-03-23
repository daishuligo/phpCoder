<?php
/**
 * Created by PhpStorm.
 * User: INXX
 * Date: 2020/2/15
 * Time: 20:59
 */

namespace app\code\controller;


class ViewCodeController extends BaseController
{
    public function generateViewCode(){
        $param = ['module','table','code_lib','fields'];
        $data = $this->getParam('param',$param);

        $data['fields'] = ['file_size','status','name'];
        //$data['table'] = $this->convertUnderline($data['table']);
        $this->assign('tableName', $data['table']);
        $this->assign('moduleName', $data['module']);
        $this->assign('fields', $data['fields']);

        $codelibName = $data['code_lib'] == '' ? 'default' : $data['code_lib'];
        $codeBasePath = __DIR__.'/../codeRepository/'.$codelibName;
        $template = file_get_contents($codeBasePath.'/view/index.html');//读取模板.
        $a = $this->display($template,[],['view_path'=>$codeBasePath.'/view/'])->getContent();

        $filePath = APP_PATH.'/'.$data['module'].'/view/';
        if(!file_exists($filePath)){
            FileUtil::createDir($filePath);
        }
        file_put_contents($filePath.$this->convertUnderline($data['table']).'index.html',$a);
        var_dump($filePath);
        echo "<pre>";
        print_r(PHP_HEAD );
        echo "</pre>";
        die;
        print_r($this->display($template,[],[]));
    }
}