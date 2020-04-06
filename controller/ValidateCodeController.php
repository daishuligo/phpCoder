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

        /*$fields = [
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
            'add' => [
                'status' => [
                    'type'  => 'in',
                    'attribute'  => 'radio',
                    'name'  => '状态',
                    'limit' => [
                        'require' => '',
                        'min'     => 10,
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
        ];*/


        $rule = [];
        $message = [];
        $scene = [];
        foreach ($data['fields'] as $k => $v){
            foreach ($v as $m => $n){
                foreach ($n['limit'] as $o => $p){
                    $scene[$k][] = "'".$m.".".$o."'";
                    if($o == 'require'){
                        $rule[$m] = $o;
                        $message[$m.'.'.$o] = $n['name'].'不能为空';
                    }elseif($o == 'number'){
                        $rule[$m] = $o;
                        $message[$m.'.'.$o] = $n['name'].'必须为数字类型';
                    }elseif($o == 'email'){
                        $rule[$m] = $o;
                        $message[$m.'.'.$o] = $n['name'].'必须为邮箱地址';
                    }elseif($o == 'phone'){
                        $rule[$m] = $o;
                        $message[$m.'.'.$o] = $n['name'].'必须为手机格式';
                    }elseif($o == 'array'){
                        $rule[$m] = $o;
                        $message[$m.'.'.$o] = $n['name'].'必须为数组类型';
                    }elseif($o == 'alpha'){
                        $rule[$m] = $o;
                        $message[$m.'.'.$o] = $n['name'].'必须为字母';
                    }elseif($o == 'date'){
                        $rule[$m] = $o;
                        $message[$m.'.'.$o] = $n['name'].'日期格式';
                    }elseif($o == 'alphaNum'){
                        $rule[$m] = $o;
                        $message[$m.'.'.$o] = $n['name'].'必须为字母或数字';
                    }elseif($o == 'alphaDash'){
                        $rule[$m] = $o;
                        $message[$m.'.'.$o] = $n['name'].'必须为字母或数字或下划线';
                    }elseif($o == 'activeUrl'){
                        $rule[$m] = $o.':'.$p;
                        $message[$m.'.'.$o] = $n['name'].'必须为有效的域名';
                    }elseif($o == 'between'){
                        $rule[$m] = $o.':'.$p;
                        $message[$m.'.'.$o] = $n['name'].'必须在'.$p.'之间';
                    }elseif($o == 'notBetween'){
                        $rule[$m] = $o.':'.$p;
                        $message[$m.'.'.$o] = $n['name'].'不可在'.$p.'之间';
                    }elseif($o == 'in'){
                        $rule[$m] = $o.':'.$p;
                        $message[$m.'.'.$o] = $n['name'].'必须在'.$p.'之中';
                    }elseif($o == 'notIn'){
                        $rule[$m] = $o.':'.$p;
                        $message[$m.'.'.$o] = $n['name'].'不可在'.$p.'之中';
                    }elseif($o == 'length'){
                        $rule[$m] = $o.':'.$p;
                        $message[$m.'.'.$o] = $n['name'].'长度必须为'.$p;
                    }elseif($o == 'max'){
                        $rule[$m] = $o.':'.$p;
                        $message[$m.'.'.$o] = $n['name'].'最大长度为'.$p;
                    }elseif($o == 'min'){
                        $rule[$m] = $o.':'.$p;
                        $message[$m.'.'.$o] = $n['name'].'最小长度为'.$p;
                    }elseif($o == 'confirm'){
                        $rule[$m] = $o.':'.$p;
                        $message[$m.'.'.$o] = $n['name'].'与'.$p.'不一致';
                    }
                }
            }
            $scene[$k] = implode(',',$scene[$k]);
        }

        /*$data['rule'] = [
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
        ];*/


        //$data['table'] = $this->convertUnderline($data['table']);
        $this->assign('tableName', $data['table']);
        $this->assign('moduleName', $data['module']);
        $this->assign('rule', $rule);
        $this->assign('message', $message);
        $this->assign('scene', $scene);
        $codelibName = $data['code_lib'] == '' ? 'default' : $data['code_lib'];
        $codeBasePath = __DIR__.'/../codeRepository/'.$codelibName;
        $template = file_get_contents($codeBasePath.'/validate/validate.html');//读取模板.
        $a = $this->display($template,[],['view_path'=>$codeBasePath.'/validate/'])->getContent();

        $filePath = APP_PATH.'/'.$data['module'].'/validate/';
        if(!file_exists($filePath)){
            FileUtil::createDir($filePath);
        }
        file_put_contents($filePath.convertUnderline($data['table']).'Validate.php', PHP_HEAD.$a);
        var_dump($filePath);
        echo "<pre>";
        print_r(PHP_HEAD .$a);
        echo "</pre>";
        die;
        print_r($this->display($template,[],[]));
    }
}