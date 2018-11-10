<?php
namespace controllers;

use \models\Role;

class RoleController extends BaseController{
    public function index()
    {
        $model = new Role;
        $data = $model->findAll();
        view('role/index',$data);
    }

    public function create()
    {
        $model = new \models\Privilege;
        $data = $model->indentation();
        // var_dump($data);
        // die;
        
        view('role/create',$data);
    }

    public function insert()
    {
        $model = new Role;
        $model->fill($_POST);
        $model->insert();
        redirect('/role/index');
    }

    public function edit()
    {
        $model = new Role;
        $RoleData = $model->findOne($_GET['id']);
        
        $priModel = new \models\Privilege;
        $priData = $priModel->indentation();

        $priIds = $model->getPrivlege($_GET['id']);
        
        view('role/edit',[
            'RoleData'=>$RoleData,
            'priData'=>$priData,
            'priIds'=>$priIds
        ]);
    }

    public function update()
    {
        $model = new Role;
        $model->fill($_POST);
        
        $model->update($_GET['id']);
        redirect('/role/index');
    }

    public function delete()
    {
        $model = new Role;
        $model->delete($_GET['id']);
        redirect('/role/index');
    }
}