<?php 
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CartModel;


class Cart extends ResourceController
{
    use ResponseTrait;
    
    public function get(){
        $model = new CartModel();
        $data['cart'] = $model->getCart();
        return $this->respond($data);
    }

 
    public function add(){
        
        $id = $this->request->getVar('id');
        $id = trim($id);
        $id = intval($id);
        
        $model = new CartModel();
        $data['result'] = $model->addItem($id);
        return $this->respond($data);
    }
    
    public function del(){
        
        $id = $this->request->getVar('id');
        $id = trim($id);
        $id = intval($id);
        
        $model = new CartModel();
        $data['result'] = $model->delItem($id);
        return $this->respond($data);
    }    
    
    
    public function order(){
        $model = new CartModel();
        $data['result'] = $model->order(array(
            'names'   => $this->request->getVar('names'),
            'email'   => $this->request->getVar('email'),
            'address' => $this->request->getVar('address'),
        ));
        return $this->respond($data);
    }    

}