<?php
namespace controllers;

use \models\Category;

class CategoryController extends BaseController{
    
    public function index()
    {
        $model = new Category;
        $data = $model->findAll([
            'order_by'=>'concat(path,id,"-")',
            'order_way'=>'asc',
            'per_page'=>2333,
        ]);
        
        view('category/index',$data);
    }

    public function create()
    {
        view('category/create');
    }

    public function insert()
    {
        $model = new Category;
        $model->fill($_POST);
        $model->insert();
        redirect('/category/index');
    }

    public function edit()
    {
        view('category/edit');
    }

    public function update()
    {
        $model = new Category;
        $model->fill($_POST);
        $model->update($_GET['id']);
        redirect('/category/index');
    }

    public function delete()
    {
        $model = new Category;
        $model->delete($_GET['id']);
        redirect('/category/index');
    }
}