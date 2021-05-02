<?php 
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CategoriesModel;


class Categories extends ResourceController
{
    use ResponseTrait;

    // all users
    public function all(){
        
      $model = new CategoriesModel();
      $model->orderBy('name', 'ASC');
      
      $data['list'] = $model->findAll();
      return $this->respond($data);
    }

 
}