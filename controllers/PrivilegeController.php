<?php
namespace controllers;

use \models\Privilege;

class PrivilegeController extends BaseController{
    public function index()
    {
        $model = new Privilege;
        $data = $model->findAll();
        view('privilege/index',$data);
    }

    public function create()
    {
        view('privilege/create');
    }

    public function insert()
    {
        $model = new Privilege;
        $model->fill($_POST);
        $model->insert();
        redirect('/privilege/index');
    }

    public function edit()
    {
        view('privilege/edit');
    }

    public function update()
    {
        $model = new Privilege;
        $model->fill($_POST);
        $model->update($_GET['id']);
        redirect('/privilege/index');
    }

    public function delete()
    {
        $model = new Privilege;
        $model->delete($_GET['id']);
        redirect('/privilege/index');
    }
}