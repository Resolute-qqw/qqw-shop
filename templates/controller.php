namespace controllers;

use \models\<?=$mname?>;

class <?=$cname?>
{
    public function index()
    {
        $model = new <?=$mname?>;
        $data = $model->findAll();
        view('<?=$tableName?>/index',$data);
    }

    public function create()
    {
        view('<?=$tableName?>/create');
    }

    public function insert()
    {
        $model = new <?=$mname?>;
        $model->fill($_POST);
        $model->insert();
        redirect('/<?=$tableName?>/index');
    }

    public function edit()
    {
        view('<?=$tableName?>/edit');
    }

    public function update()
    {
        $model = new <?=$mname?>;
        $model->fill($_POST);
        $model->update($_GET['id']);
        redirect('/<?=$tableName?>/index');
    }

    public function delete()
    {
        $model = new <?=$mname?>;
        $model->delete($_GET['id']);
        redirect('/<?=$tableName?>/index');
    }
}