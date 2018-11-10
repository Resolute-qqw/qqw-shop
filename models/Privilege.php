<?php
namespace models;

class Privilege extends Model
{
   protected $table = 'privilege';
   protected $fileable = ['pri_name','url_path','parent_id'];
}