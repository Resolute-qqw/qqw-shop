<?php
namespace models;

class Goods extends Model
{
   protected $table = 'goods';
   protected $fileable = ['goods_name','logo','is_on_sale','description','cat1_id','cat2_id','cat3_id','brand_id'];
}