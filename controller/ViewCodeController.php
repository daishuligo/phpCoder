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

        $fields = [
            'list' => [
                'status' => [
                    'type'  => 'in',
                    'attribute'  => 'radio',
                    'name'  => '状态',
                    'limit' => [
                        'require' => '',
                        'max'     => 50,
                    ],
                ],
                'name' => [
                    'type'  => 'in',
                    'attribute'  => 'img',
                    'name'  => '状态',
                    'limit' => [
                        'require' => '',
                        'max'     => 50,
                    ],
                ],
                'start_time' => [
                    'type'  => 'time',
                    'attribute'  => 'time',
                    'name'  => '开始时间',
                    'limit' => [
                        'require' => '',
                        'max'     => 50,
                    ],
                ],
            ],
        ];

        $methodFields = [];
        foreach ($fields as $k => $v){
            if($k == 'list'){
                foreach ($v as $m => $n){
                    $methodFields[$m] = $n;
                }
            }
        }
        var_dump($methodFields);
        //$data['table'] = $this->convertUnderline($data['table']);
        $this->assign('tableName', $data['table']);
        $this->assign('moduleName', $data['module']);
        $this->assign('fields', $methodFields);

        $codelibName = $data['code_lib'] == '' ? 'default' : $data['code_lib'];
        $codeBasePath = __DIR__.'/../codeRepository/'.$codelibName;
        $indexTemplate = file_get_contents($codeBasePath.'/view/index.html');//读取模板.
        $addTemplate = file_get_contents($codeBasePath.'/view/add.html');//读取模板.
        $editTemplate = file_get_contents($codeBasePath.'/view/edit.html');//读取模板.
        $index = $this->display($indexTemplate,[],['view_path'=>$codeBasePath.'/view/'])->getContent();
        $add = $this->display($addTemplate,[],['view_path'=>$codeBasePath.'/view/'])->getContent();
        $edit = $this->display($editTemplate,[],['view_path'=>$codeBasePath.'/view/'])->getContent();

        $filePath = APP_PATH.'/'.$data['module'].'/view/';
        if(!file_exists($filePath)){
            FileUtil::createDir($filePath);
        }
        file_put_contents($filePath.'index.html',$index);
        file_put_contents($filePath.'add.html',$add);
        file_put_contents($filePath.'edit.html',$edit);
    }
}