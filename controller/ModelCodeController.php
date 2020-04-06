<?php
/**
 * Created by PhpStorm.
 * User: INXX
 * Date: 2020/2/15
 * Time: 20:58
 */

namespace app\code\controller;


class ModelCodeController extends BaseController
{
    public function generateModelCode2(){
        var_dump(config('code.app_namespace'));
        var_dump(config('database.prefix'));

        define('PHP_HEAD', "<?php\r\n");
        $param = ['module','table','code_lib','fields'];
        $data = $this->getParam('param',$param);
        $data['fields'] = [
            'file_size' => [
                'type' => 'eq',
            ],
            'id' => [
                'type' => 'eq',
            ],
            'status' => [
                'type' => 'in',
            ],
            'name' => [
                'type' => 'like',
            ],
            'create_time' => [
                'type' => 'time',
            ],
        ];
        //$data['table'] = $this->convertUnderline($data['table']);
        $this->assign('tableName', $data['table']);
        $this->assign('moduleName', $data['module']);
        $this->assign('fields', $data['fields']);
        $codelibName = $data['code_lib'] == '' ? 'default' : $data['code_lib'];
        $codeBasePath = __DIR__.'/../codeRepository/'.$codelibName;
        $template = file_get_contents($codeBasePath.'/model/model.html');//读取模板.
        $a = $this->display($template,[],['view_path'=>$codeBasePath.'/model/'])->getContent();

        $filePath = APP_PATH.'/'.$data['module'].'/model/';
        if(!file_exists($filePath)){
            FileUtil::createDir($filePath);
        }
        file_put_contents($filePath.$this->convertUnderline($data['table']).'Model.php', PHP_HEAD.$a);
        var_dump($filePath);
        echo "<pre>";
        print_r(PHP_HEAD .$a);
        echo "</pre>";
        die;
        print_r($this->display($template,[],[]));
    }

    public function generateModelCode(){
        define('PHP_HEAD', "<?php\r\n");
        $param = ['module','table','code_lib','fields'];
        $data = $this->getParam('param',$param);


        $methodFields = [];
        foreach ($data['fields'] as $k => $v){
            if($k == 'list'){
                foreach ($v as $m => $n){
                    $methodFields[$m] = ['type' => $n['type']];
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
        $template = file_get_contents($codeBasePath.'/model/model.html');//读取模板.
        $a = $this->display($template,[],['view_path'=>$codeBasePath.'/model/'])->getContent();

        $filePath = APP_PATH.$data['module'].'/model/';
        if(!file_exists($filePath)){
            FileUtil::createDir($filePath);
        }
        file_put_contents($filePath.convertUnderline($data['table']).'Model.php', PHP_HEAD.$a);

    }
}