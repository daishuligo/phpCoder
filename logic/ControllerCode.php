<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/3/23
 * Time: 9:54
 */

namespace app\code\logic;


class ControllerCode
{
    public function generateControllerCode($module,$table,$fields,$template = null){
        define('PHP_HEAD', "<?php\r\n");

        $this->assign('tableName', $module);
        $this->assign('moduleName', $table);
        $this->assign('fields', $fields);
        $codelibName = $template == null ? 'default' : $template;
        $codeBasePath = __DIR__.'/../codeRepository/'.$codelibName;
        $template = file_get_contents($codeBasePath.'/controller/controller.html');//读取模板.
        $a = $this->display($template,[],['view_path'=>$codeBasePath.'/controller/'])->getContent();

        $filePath = APP_PATH.'/'.$module.'/controller/';
        if(!file_exists($filePath)){
            FileUtil::createDir($filePath);
        }

        try{
            file_put_contents($filePath.$this->convertUnderline($table.'Controller.php', PHP_HEAD.$a);
        }catch (\Exception $e){
            return [
                'status' => false,
                'msg'    => $e->getMessage(),
            ];
        }

        return [
            'status' => true,
            'msg'    => '生成控制器成功',
        ];
    }
}