<?php
namespace models;
class Model{

    protected $pdo;
    protected $table;
    protected $data;
    protected $fileable;
    
    protected function _before_write(){}
    protected function _after_write(){}
    protected function _before_delete(){}
    protected function _after_delete(){}

    public function __construct(){
        $this->pdo = \libs\Db::make();
    }

    public function fill($data){
        
        foreach($data as $k=>$v){
            if(!in_array($k,$this->fileable)){
                unset($data[$k]);
            }
        } 
        
        $this->data = $data;
    }
    
    public function insert(){
        $this->_before_write();
        
        $keys = [];
        $values = [];
        $occupy = [];
        
        foreach($this->data as $k=>$v){
            $keys[] = $k;
            $values[] = $v;
            $occupy[] = '?';
        }
        $keys = implode(",",$keys);
        $occupy = implode(",",$occupy);

        $sql = "INSERT INTO {$this->table}($keys) VALUE($occupy)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);

        $this->data['id'] = $this->pdo->lastInsertId();

        $this->_after_write();
    }

    public function update($id){
        
        $this->_after_write();

        $set = [];

        foreach($this->data as $k=>$v){
            $set[] = "$k=?";
            $values[] = $v;
        }
        $set = implode(",",$set);
        $values[] = $id;

        $sql = "UPDATE {$this->table} SET $set WHERE id=?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);

        $this->_before_write();

    }

    public function delete(){
        $this->_before_delete();
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id=?");
        
        $stmt->execute([$_GET['id']]);
    }


    // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    public function findAll($options = [])
    {
        
        $_option = [
            'fields' => '*',
            'where' => 1,
            'order_by' => 'id',
            'order_way' => 'desc',
            'per_page'=>20,
        ];
        // 合并用户的配置
        if($options)
        {
            $_option = array_merge($_option, $options);
        }
        /**
         * 翻页
         */
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($page-1)*$_option['per_page'];
        
        $sql = "SELECT {$_option['fields']}
                 FROM {$this->table}
                 WHERE {$_option['where']} 
                 ORDER BY {$_option['order_by']} {$_option['order_way']} 
                 LIMIT $offset,{$_option['per_page']}";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll( \PDO::FETCH_ASSOC );
        /**
         * 获取总的记录数
         */
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM {$this->table} WHERE {$_option['where']}");
        $stmt->execute();
        $count = $stmt->fetch( \PDO::FETCH_COLUMN );
        $pageCount = ceil($count/$_option['per_page']);

        $page_str = '';
        if($pageCount>1)
        {
            for($i=1;$i<=$pageCount;$i++)
            {
                $page_str .= '<a href="?page='.$i.'">'.$i.'</a> ';
            }
        }
        

        return [
            'data' => $data,
            'page' => $page_str,
        ];
    }

    public function findOne($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch( \PDO::FETCH_ASSOC );
    }

    // xxxxxxxxxxxxxxxxxxxxxxxxx
    // 排序
    public function indentation(){
        $data = $this->findAll();
        $resute = $this->recursion($data['data']);
        return $resute;
        
    }
    // 递归
    public function recursion($data,$parent=0,$lever=0){
        static $resute = [];
        foreach($data as $v){
            if($v['parent_id']==$parent){

                $v['lervel']=$lever;
                $resute[] = $v;
                $this->recursion($data,$v['id'],$lever+1);
            }
        }
        return $resute;
    }
    
}