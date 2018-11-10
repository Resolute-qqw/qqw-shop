<?php
namespace controllers;

use \models\Admin;

class LoginController{
    public function login(){
        view("login/login");
    }

    public function dologin(){

        $admin = new Admin;

        try{
            $admin->login($_POST['username'],md5($_POST['password']));
            redirect("/index/index");
        }catch(\Exception $e){
            redirect("/login/login");
        }

    }
    public function logout(){
        $_SESSION=[];
        redirect("/login/login");
    }
}