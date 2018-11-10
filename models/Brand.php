<?php
namespace models;

class Brand extends Model
{
   protected $table = 'brand';
   protected $fileable = ['brand_name','logo'];
}