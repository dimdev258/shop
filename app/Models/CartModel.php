<?php
namespace App\Models;
use CodeIgniter\Model;
use App\Models\ProductsModel;

class CartModel extends Model{
    
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 
        'total', 
        'names', 
        'email', 
        'address', 
        'products', 
    ];
    
    
    
    private static $cart = array(
        'products' => array() ,
        'count'    => 0 ,
        'total'    => 0 ,
        'names'    => '' ,
        'email'    => '' ,
        'address'  => '' ,
    );

    
    public function order($imputs=array()) {
        
        // RESULT ........................
        $result = array();
        $result['order_id'] = 0;
        $result['errors'] = array();
        
        // INPUTS ..........................
        $imputs = array_merge(array(
            'names'   => '',
            'email'   => '',
            'address' => '',
        ), $imputs);
        $imputs['names']   = trim($imputs['names']);
        $imputs['email']   = trim($imputs['email']);
        $imputs['address'] = trim($imputs['address']);
        
        
        // CART ..........................
        $cart = $this->getCart();
        
        // CHECK ..........................
        if(strlen($imputs['names']) == 0){
            $result['errors'][] = 'names is empty';
        }
        if(strlen($imputs['email']) == 0){
            $result['errors'][] = 'email is empty';
        }
        if (!filter_var($imputs['email'], FILTER_VALIDATE_EMAIL)) {
            $result['errors'][] = 'invalid email';
        }
        if(strlen($imputs['address']) == 0){
            $result['errors'][] = 'address is empty';
        }
        if(count($cart['products']) == 0){
            $result['errors'][] = 'cart is empty';
        }
        
        
        // CHECK ..........................
        if(count($result['errors']) > 0){
            return $result;
        }
        
        // CART ..........................
        $cart['names'] = $imputs['names'];
        $cart['email'] = $imputs['email'];
        $cart['address'] = $imputs['address'];
        
        
        // INSERT ..........................
        $result['order_id'] = $this->insert(array(
            'total'    => $cart['total'],
            'names'    => $cart['names'],
            'email'    => $cart['email'],
            'address'  => $cart['address'],
            'products' => json_encode($cart['products']),
        ));
       
        // CART ..........................
        $this->resetCart();
        
        // <<<<<<<<<<<<
        return $result;
        
        
        
    }    
    
    
    public function getCart() {
        $session = session();
        if(!$session->has('cart')){
            $cart = self::$cart;
            $session->set('cart', $cart);
        }
        return $session->get('cart');
    }
    public function resetCart() {
        $session = session();
        $cart = self::$cart;
        $session->set('cart', $cart);
    }
    public function setCart($cart) {
        
        $total = 0;
        $count = 0;
        foreach ($cart['products'] as $id => &$product) {
            $sum = $product['price'] * $product['quantity'];
            $sum = floatval(number_format($sum, 2));
            $product['sum'] = $sum;
            $total += $sum;
            $count += $product['quantity'];
        }
        $cart['total'] = $total;
        $cart['count'] = $count;
        
        $session = session();
        $session->set('cart', $cart);
        
    }

    public function addItem($id) {
        
        // PREPARE ........................
        $result = array();
        $result['errors'] = array();
        
        // CHECK ........................
        if(!is_numeric($id)){
            $result['errors'][] = 'System error #10';
            return $result;
        }
        if($id <= 0){
            $result['errors'][] = 'System error #11';
            return $result;
        }
        
        
        // PRODUCT ........................
        $model = new ProductsModel();
        $product = $model->find($id);
        
        // CHECK ........................
        if(!is_array($product)){
            $result['errors'][] = 'System error #12';
            return $result;
        }
        
        //..............................
        $cart = $this->getCart();
        
        // ADD ..............................
        if(!key_exists($id, $cart['products'])){
            
            $product['quantity'] = 1;
            $cart['products'][$id] = $product;
        }
        
        // UPDATE ..............................
        else{
            $cart['products'][$id]['quantity'] = $cart['products'][$id]['quantity']+1;
        }
        
        $this->setCart($cart);
        
        //.....................
        return $result;
    }
    
    
    public function delItem($id) {
        
        // PREPARE ........................
        $result = array();
        $result['errors'] = array();
        
        //..............................
        $cart = $this->getCart();
        if(key_exists($id, $cart['products'])){
            unset($cart['products'][$id]);
            $this->setCart($cart);
        }
        
        //.....................
        return $result;
        
    }
    
    
}
