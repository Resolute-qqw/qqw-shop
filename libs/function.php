<?php

function view($file,$data=[]){
    extract($data);
    require ROOT."views/".$file.".html";
}
function redirect($path){
    header('Location:'.$path);
}