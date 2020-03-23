<?php
/**
 * Created by PhpStorm.
 * User: INXX
 * Date: 2020/2/15
 * Time: 20:58
 */

namespace app\code\controller;


class ValidateCodeController extends BaseController
{
    public function generateValidateCode(){
        define('PHP_HEAD', "<?php\r\n");
        $param = ['module','table','code_lib','fields'];
        $data = $this->getParam('param',$param);
        $data['rule'] = [
            'file_size' => 'require|max:25',
            'id' => 'require|max:25',
            'status' => 'require|max:25',
            'name' => 'require|max:25',
            'create_time' => 'require|max:25',
        ];

        $data['message'] = [
            'file_size.require' => '必须',
            'file_size.max' => '最大',
            'id.require' => '必须',
            'id.max' => '最大',
            'status.require' => '必须',
            'status.max' => '最大',
            'name.require' => '必须',
            'name.max' => '最大',
            'create_time.require' => '必须',
            'create_time.max' => '最大',
        ];

        $data['scene'] = [
            'list' => 'file_size.require,file_size.max',
            'edit' => 'file_size.require,file_size.max',
            'add' => 'file_size.require,file_size.max',
        ];

        //$data['table'] = $this->convertUnderline($data['table']);
        $this->assign('tableName', $data['table']);
        $this->assign('moduleName', $data['module']);
        $this->assign('rule', $data['rule']);
        $this->assign('message', $data['message']);
        $this->assign('scene', $data['scene']);
        $codelibName = $data['code_lib'] == '' ? 'default' : $data['code_lib'];
        $codeBasePath = __DIR__.'/../codeRepository/'.$codelibName;
        $template = file_get_contents($codeBasePath.'/validate/validate.html');//读取模板.
        $a = $this->display($template,[],['view_path'=>$codeBasePath.'/validate/'])->getContent();

        $filePath = APP_PATH.'/'.$data['module'].'/validate/';
        if(!file_exists($filePath)){
            FileUtil::createDir($filePath);
        }
        file_put_contents($filePath.$this->convertUnderline($data['table']).'Validate.php', PHP_HEAD.$a);
        var_dump($filePath);
        echo "<pre>";
        print_r(PHP_HEAD .$a);
        echo "</pre>";
        die;
        print_r($this->display($template,[],[]));
    }
}