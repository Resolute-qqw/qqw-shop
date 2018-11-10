<?php
namespace libs;
class Db{

    private static $obj=null;
    private $pdo;
    private function __clone(){}
    private function __construct(){
        $this->pdo = new \PDO("mysql:host=127.0.0.1;dbname=qqwshop","root","123456");
        $this->pdo->exec("SET names utf8");
    }
    public static function make(){
        if(self::$obj===null){
            self::$obj = new self;
        }
        return self::$obj;
    }

    public function prepare($sql){
        return $this->pdo->prepare($sql);
    }

    // 非预处理执行SQL
    public function exec($sql)
    {
        return $this->pdo->exec($sql);
    }

    // 获取最新添加的记录的ID
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
