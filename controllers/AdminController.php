<?php
namespace controllers;

use \models\Admin;

class AdminController extends BaseController{
    public function index()
    {
        $model = new Admin;
        $data = $model->findAll();
        view('admin/index',$data);
    }

    public function create()
    {   
        $model = new \models\Role;
        $data = $model->findAll();
        
        view('admin/create',[
            'data'=>$data['data'],
        ]);
    }

    public function insert()
    {
        $model = new Admin;
        $model->fill($_POST);
        $model->insert();
        redirect('/admin/index');
    }

    public function edit()
    {
        view('admin/edit');
    }

    public function update()
    {
        $model = new Admin;
        $model->fill($_POST);
        $model->update($_GET['id']);
        redirect('/admin/index');
    }

    public function delete()
    {
        $model = new Admin;
        $model->delete($_GET['id']);
        redirect('/admin/index');
    }


}