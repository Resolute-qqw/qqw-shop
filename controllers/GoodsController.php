<?php
namespace controllers;

use \models\Goods;

class GoodsController extends BaseController{

    public function ajax_get_cat(){

        $id = (int)$_GET['id'];
        $model = new \models\Category;
        $data = $model->getCat($id);
        echo json_encode($data);
    }

    public function index()
    {
        $model = new Goods;
        $data = $model->findAll();
        view('goods/index',$data);
    }

    public function create()
    {
        $model = new \models\Category;
        $catedata = $model->getCat();
        view('goods/create',[
            'catedata'=>$catedata['data'],
        ]);
    }

    public function insert()
    {
        $model = new Goods;
        $model->fill($_POST);
        $model->insert();
        redirect('/goods/index');
    }

    public function edit()
    {
        view('goods/edit');
    }

    public function update()
    {
        $model = new Goods;
        $model->fill($_POST);
        $model->update($_GET['id']);
        redirect('/goods/index');
    }

    public function delete()
    {
        $model = new Goods;
        $model->delete($_GET['id']);
        redirect('/goods/index');
    }

}