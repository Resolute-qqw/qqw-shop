<?php
namespace controllers;

class CodeController extends BaseController{
    function make(){

        $tableName = $_GET['name'];

        $sql = "SHOW FULL FIELDS FROM ".$tableName;
        $db = \libs\Db::make();
        
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $dbData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        var_dump($dbData);
        die;
        $fileable=[];
        foreach($dbData as $v){
            if($v['Field']=='id' || $v['Field']=='created_at')
                continue;
            $fileable[] = $v['Field'];
        }
        $fileable = implode("','",$fileable);
        
        $cname = ucfirst($tableName)."Controller";
        $mname = ucfirst($tableName);
        
        //生成控制器
        ob_start();
        include ROOT."templates/controller.php";
        $str = ob_get_clean();
        file_put_contents(ROOT."controllers/".$cname.".php","<?php\r\n".$str);

        // 生成模型
        ob_start();
        include ROOT."templates/model.php";
        $str = ob_get_clean();
        file_put_contents(ROOT."models/".$mname.".php","<?php\r\n".$str);

        // 生成视图文件
        @mkdir(ROOT."views/".$tableName,0777);

        ob_start();
        include ROOT."templates/create.html";
        $str = ob_get_clean();
        file_put_contents(ROOT."views/".$tableName."/create.html",$str);

        ob_start();
        include ROOT."templates/edit.html";
        $str = ob_get_clean();
        file_put_contents(ROOT."views/".$tableName."/edit.html",$str);
        
        ob_start();
        include ROOT."templates/index.html";
        $str = ob_get_clean();
        file_put_contents(ROOT."views/".$tableName."/index.html",$str);



    }
}