<?php 
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductsModel;


class Products extends ResourceController
{
    use ResponseTrait;

    // all users
    public function index(){
        
        $search      = trim($this->request->getVar('search'));

        $category_id = $this->request->getVar('category_id');
        $category_id = trim($category_id);
        $category_id = intval($category_id);

        $model = new ProductsModel();
        if($category_id > 0){
            $model->where('category_id', $category_id);
        }
        if(strlen($search) > 0){
            $model->like('name', $search);
        }
        $model->orderBy('name', 'DESC');

        $data['products'] = $model->findAll();
        
        return $this->respond($data);
    }

 
}