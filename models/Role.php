<?php
namespace models;

class Role extends Model
{
   protected $table = 'role';
   protected $fileable = ['role_name'];

   protected function _after_write(){
        $roleId = isset($_GET['id']) ? $_GET['id'] : $this->data['id'];
        
        $stmt = $this->pdo->prepare('DELETE FROM role_privlege WHERE role_id=?');
        $stmt->execute([
            $roleId
        ]);

        $stmt = $this->pdo->prepare("INSERT INTO role_privlege(pri_id,role_id) VALUES(?,?)");
        // var_dump($_POST);
        // die;
        foreach($_POST['pri_id'] as $v){
            $stmt->execute([
                $v,
                $roleId
            ]);
        }
        
   }
   protected function _before_delete(){
        $roleId = isset($_GET['id']) ? $_GET['id'] : $this->data['id'];

        $stmt = $this->pdo->prepare('DELETE FROM role_privlege WHERE role_id=?');
        $stmt->execute([
            $roleId
        ]);
   }

   public function getPrivlege($roleId){
        $stmt = $this->pdo->prepare("SELECT pri_id FROM role_privlege WHERE role_id=?");
        $stmt->execute([$roleId]);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $res = [];
        foreach($data as $v){
            $res[] = $v['pri_id'];
        }
        
        return $res;
   }

}