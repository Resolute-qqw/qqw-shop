<?php
namespace controllers;

class IndexController extends BaseController{
    function index(){
        view('index/index');
    }
    function top(){
        view('index/top');
    }
    function menu(){
        view('index/menu');
    }
    function main(){
        view('index/main');
    }
}