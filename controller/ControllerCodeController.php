<?php
/**
 * Created by PhpStorm.
 * User: INXX
 * Date: 2020/2/15
 * Time: 20:58
 */

namespace app\code\controller;


use app\code\logic\ControllerCode;
use think\Db;

class ControllerCodeController extends BaseController
{
    public function index(){
        $sql = "show tables";
        $tableList = Db::query($sql);
        $tableList = array_column($tableList,'Tables_in_'.config('database.database'));
        var_dump($tableList);
        $this->assign('table_list',$tableList);
        return $this->fetch();
    }

    public function getFields(){
        $table = $this->request->param('table_name');
        /*if(!$table){
            $this->result([],0,'数据表不能为空','json');
        }*/

        $res = $this->getTableFields($table);
        if(!$res['status']){
            $this->result([],0,$res['msg'],'json');
        }


        $this->result($res['data'],1,'获取数据表字段成功','json');
    }

    public function generateControllerCode2(){
        $param = ['module','table','code_lib','fields'];
        $data = $this->getParam('param',$param);

        $controllerCode = new ControllerCode();
        $res = $controllerCode->generateControllerCode($data['module'],$data['table']);
        var_dump($res);
        die;
        define('PHP_HEAD', "<?php\r\n");

        //$data['table'] = $this->convertUnderline($data['table']);
        $this->assign('tableName', $data['table']);
        $this->assign('moduleName', $data['module']);
        $codelibName = $data['code_lib'] == '' ? 'default' : $data['code_lib'];
        $codeBasePath = __DIR__.'/../codeRepository/'.$codelibName;
        $template = file_get_contents($codeBasePath.'/controller/controller.html');//读取模板.
        $a = $this->display($template,[],['view_path'=>$codeBasePath.'/controller/'])->getContent();
        //$filePath = $codeBasePath.'/'.$this->convertUnderline($data['table']).'Controller.php';
        $filePath = APP_PATH.'/'.$data['module'].'/controller/';
        if(!file_exists($filePath)){
            FileUtil::createDir($filePath);
        }
        file_put_contents($filePath.$this->convertUnderline($data['table']).'Controller.php', PHP_HEAD.$a);
        var_dump($filePath);
        echo "<pre>";
        print_r(PHP_HEAD .$a);
        echo "</pre>";
        die;
        print_r($this->display($template,[],[]));
    }

    public function generateControllerCode(){
        define('PHP_HEAD', "<?php\r\n");

        $param = ['module','table','code_lib','fields'];
        $data = $this->getParam('param',$param);

        $method = ['list','add','edit','delete'];
        $methodFields = [];
        foreach ($data['fields'] as $k => $v){
            if(in_array($k,$method)){
                if($k == 'list'){
                    foreach ($v as $m => $n){
                        if($n['type'] == 'time'){
                            $methodFields[$k][] = "'start_".$m."'";
                            $methodFields[$k][] = "'end_".$m."'";
                        }else{
                            $methodFields[$k][] = "'".$m."'";
                        }
                    }
                    $methodFields[$k][] = "'size'";
                    $methodFields[$k] = implode(',',$methodFields[$k]);
                }else{
                    foreach ($v as $m => $n){
                        $methodFields[$k][] = "'".$m."'";
                    }
                    $methodFields[$k] = implode(',',$methodFields[$k]);
                }
            }
        }

        var_dump($data);
        $this->assign('tableName', $data['table']);
        $this->assign('moduleName', $data['module']);
        $this->assign('methodFields', $methodFields);
        $codelibName = $data['code_lib'] == '' ? 'default' : $data['code_lib'];
        $codeBasePath = __DIR__.'/../codeRepository/'.$codelibName;
        $template = file_get_contents($codeBasePath.'/controller/controller.html');//读取模板.
        $a = $this->display($template,[],['view_path'=>$codeBasePath.'/controller/'])->getContent();

        $filePath = APP_PATH.$data['module'].'/controller/';
        if(!file_exists($filePath)){
            FileUtil::createDir($filePath);
        }

        file_put_contents($filePath.convertUnderline($data['table'].'Controller.php'), PHP_HEAD.$a);

    }
}