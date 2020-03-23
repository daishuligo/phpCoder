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
    public function generateControllerCode($module,$table,$fields = [],$template = null){
        define('PHP_HEAD', "<?php\r\n");

        $fields = [
            'add' => [
                'status' => [
                    'type'  => 'in',
                    'limit' => [
                        'require' => '',
                        'max'     => 50,
                    ],
                ],
                'start_time' => [
                    'type'  => 'time',
                    'limit' => [
                        'require' => '',
                        'max'     => 50,
                    ],
                ],
            ],
        ];

        $method = ['list','add','edit','delete'];
        $methodFields = [];
        foreach ($fields as $k => $v){
            if(in_array($k,$method)){
                if($k == 'list'){
                    foreach ($v as $m => $n){
                        if($n['type'] == 'time'){
                            $methodFields[$k][] = 'start_'.$m;
                            $methodFields[$k][] = 'end_'.$m;
                        }else{
                            $methodFields[$k][] = $m;
                        }
                    }
                }else{
                    $methodFields[$k] = array_keys($v);
                }
            }
        }

        $this->assign('tableName', $module);
        $this->assign('moduleName', $table);
        $this->assign('methodFields', $methodFields);
        $codelibName = $template == null ? 'default' : $template;
        $codeBasePath = __DIR__.'/../codeRepository/'.$codelibName;
        $template = file_get_contents($codeBasePath.'/controller/controller.html');//读取模板.
        $a = $this->display($template,[],['view_path'=>$codeBasePath.'/controller/'])->getContent();

        $filePath = APP_PATH.'/'.$module.'/controller/';
        if(!file_exists($filePath)){
            FileUtil::createDir($filePath);
        }

        try{
            file_put_contents($filePath.$this->convertUnderline($table.'Controller.php', PHP_HEAD.$a));
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