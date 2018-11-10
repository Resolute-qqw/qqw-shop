<?php
namespace controllers;
class BaseController{

    public function __construct(){
        if(!isset($_SESSION['id'])){
            redirect("/login/login");
        }
        // 数据库没查询出   待修改（BaseController）
        var_dump($_SESSION);
        die;
        if(isset($_SESSION['root']) && $_SESSION['root']!=false){
            
        }else{
            $path = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:"index/index";
            
            $whiteList = ['/index/index','/index/menu','/index/top','/index/main'];
            // var_dump($path,$whiteList,$_SESSION['url_path']);
            // die;
            if(!in_array($path,array_merge($whiteList,$_SESSION['url_path']))){
                die("无权访问");
            }
        }
    }

}