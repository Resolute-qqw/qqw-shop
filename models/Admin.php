<?php
namespace models;

class Admin extends Model
{
   protected $table = 'admin';
   protected $fileable = ['username','password'];

    public function _before_write(){
            $this->data['password'] = md5($this->data['password']);
    }
    public function _after_write(){

        $roleId = isset($_GET['id']) ? $_GET['id'] : $this->data['id'];
        
        $stmt = $this->pdo->prepare('DELETE FROM admin_role WHERE admin_id=?');
        $stmt->execute([
            $roleId
        ]);

        $stmt = $this->pdo->prepare("INSERT INTO admin_role(role_id,admin_id) VALUES(?,?)");
        // var_dump($_POST);
        // die;
        foreach($_POST['role'] as $v){
            $stmt->execute([
                $v,
                $roleId
            ]);
        }
    }

    protected function _before_delete()
    {
        $stmt = $this->pdo->prepare("delete from admin_role where admin_id=?");
        $stmt->execute([
            $_GET['id']
        ]);
    }
    public function login($uname,$pwd){
        $stmt = $this->pdo->prepare("SELECT * FROM admin WHERE username=? AND password=? ");
        $stmt->execute([
            $uname,
            $pwd
        ]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        $_SESSION['id'] = $data['id'];
        $_SESSION['username']= $data['username'];

        if($data){
            // 数据库没查询出   待修改
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM admin_role WHERE role_id=1 ADN admin_id=?");
            $stmt->execute($data['id']);
            $root = $stmt->fetch(\PDO::FETCH_COLUMN);
            if($root>0){
                $_SESSION['root']=true;
            }else{
                $_SESSION['url_path'] = $this->getUrlPath($_SESSION['id']);
            }

        }else{
            throw new \Exception("用户名或者密码错误");
        }
        
    }
    public function getUrlPath($adminId){
        $sql = "select p.url_path from admin_role ar
        LEFT JOIN role_privlege rp ON ar.role_id=rp.role_id 
        LEFT JOIN privilege p ON rp.pri_id=p.id
        where ar.admin_id = 3 AND p.url_path!='/'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$adminId]);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $res = [];
        foreach($data as $v){
            if(strpos($v['url_path'],",")){
                $res = array_merge($res,explode(",",$v['url_path']));
            }else{
                $res[] = ($v['url_path']);
            }
            
        }
      
        return $res;
    }

}