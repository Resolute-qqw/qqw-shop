<?php
namespace controllers;

use \models\Brand;

class BrandController extends BaseController{
    public function index()
    {
        $model = new Brand;
        $data = $model->findAll();
        view('brand/index',$data);
    }

    public function create()
    {
        view('brand/create');
    }

    public function insert()
    {
        $model = new Brand;
        $model->fill($_POST);
        $model->insert();
        redirect('/brand/index');
    }

    public function edit()
    {
        view('brand/edit');
    }

    public function update()
    {
        $model = new Brand;
        $model->fill($_POST);
        $model->update($_GET['id']);
        redirect('/brand/index');
    }

    public function delete()
    {
        $model = new Brand;
        $model->delete($_GET['id']);
        redirect('/brand/index');
    }
}