<?php
namespace models;

class Category extends Model
{
    protected $table = 'category';
    protected $fileable = ['cat_name','parent_id','path'];

    public function getCat($parent = 0){
        return $this->findAll([
            'where'=>"parent_id=$parent",
        ]);
    }
}