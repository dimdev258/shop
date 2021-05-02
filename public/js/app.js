var app = angular.module('app',[
    'directives',
    'controllers',
    'ngRoute'
]);

// SERVICES .....................................
app.service("CategoryService", ['$http' , function($http) {
        
    this.all = function(){
        return $http({
            method: 'GET',
            url: 'categories/all'
        })
    };

}]);
app.service("ProductService", ['$http' , function($http) {
        
    this.all = function(category_id, search){
        return  $http({
            method: 'GET',
            url: 'products?search='+search+'&category_id='+category_id
        });
    };

}]);

app.service("CartService", ['$http' , function($http) {
        
    this.get = function(){
        return $http({
            method: 'GET',
            url: 'cart/get'
        });
    };        
        
    this.add = function(id){
        return  $http({
            method: 'POST',
            url: 'cart/add',
            data: { 
                id: id 
            }
        });
    };
    
    this.delete = function(id){
        return $http({
            method: 'POST',
            url: 'cart/del',
            data: { 
                id: id 
            }
        });
    };
    
    this.order = function(data){
        return $http({
            method: 'POST',
            url: 'cart/order',
            data : {
                'names'   : data.names,
                'email'   : data.email,
                'address' : data.address,
            }
        })
    };    
    

}]);
// SERVICES .....................................



// CONFIG ........................................................
app.config(['$routeProvider', function($routeProvider) {
        
   $routeProvider
       .when('/', {
           templateUrl : "templates/page.index.html",
       });
       
   $routeProvider
       .when('/cart', {
           templateUrl : "templates/page.cart.html",
       });
        
    $routeProvider.otherwise({redirectTo: '/'});
    
}]);
// CONFIG ........................................................


// DIRECTIVES .....................................
directives = angular.module('directives', []);
directives.directive('productsIterate',  function() {
    return {
        templateUrl: 'templates/component.products.iterate.html' 
    };
});
directives.directive('cartNotification',  function() {
    return {
        templateUrl: 'templates/component.cart.notification.html' 
    };
});
directives.directive('cartOrder',  function() {
    return {
        templateUrl: 'templates/component.cart.order.html' 
    };
});
// DIRECTIVES .....................................


// CONTROLLERS ........................................................
controllers = angular.module('controllers', []);


// CONTROLLERS/PPRODUCTS ........................................................
controllers.controller('ProductsController', [
    
    '$scope', 
    '$rootScope',  
    'CategoryService',
    'ProductService',
    'CartService',
    
    function(
        $scope, 
        $rootScope, 
        CategoryService,
        ProductService,
        CartService
    ) {
        
    // DATA .....................    
    $scope.search = '';
    $scope.products = [];
    $scope.categories = [];
    $scope.category_id = 0;
    
    
    // CATEGORIES .....................    
    $scope.categoriesLoad = function () {
       
        CategoryService.all().then(
            function successCallback(response) {
                var categories = response.data.list;
                categories.unshift({
                    'id'   : 0 ,
                    'name' : ''
                });
                $scope.categories = categories;
                
            }, 
            function errorCallback(response) {}
        );
        
    };
    $scope.categoriesLoad();
   
    
    // FILTER .....................    
    $scope.filtrate = function () {
        ProductService.all($scope.category_id, $scope.search).then(
            function successCallback(response) {
                $scope.products = response.data.products;
            }, 
            function errorCallback(response) {}
        );
        
    };
    $scope.filtrate();
    
    
    // BUY .....................    
    $scope.buy = function (id) {
        CartService.add(id).then(
            function successCallback(response) {
                $rootScope.$broadcast('cart_is_changed');
            }, 
            function errorCallback(response) {}
        );
    };
    
}]);

// CONTROLLERS/PPRODUCTS ........................................................


// CONTROLLERS/CART/NOTIFICATION ........................................................
controllers.controller('CartNotificationController', [
    
    '$scope', 
    '$rootScope', 
    '$location' , 
    'CartService',
    
    function(
        $scope, 
        $rootScope, 
        $location,
        CartService
    ){
        
    // DATA ..................    
    $scope.count = 0;
        
    // ON ..................        
    $rootScope.$on("cart_is_changed", function(){
        $scope.refresh();
    });
    
    // REFRESH .....................    
    $scope.refresh = function () {
        CartService.get().then(
            function successCallback(response) {
                $scope.count = response.data.cart.count;
            }, 
            function errorCallback(response) {}
        );
    };
    
    // OPEN .....................    
    $scope.open = function () {
        if(!parseInt($scope.count)){
            return null;
        }
        $location.path("/cart");
    };    
    
    
    // INIT .............
    $scope.refresh();
    
    
}]);

// CONTROLLERS/CART/NOTIFICATION ........................................................


// CONTROLLERS/CART ........................................................
controllers.controller('CartController', [
    
    '$scope', 
    '$rootScope',  
    '$location' , 
    'CartService',
    
    function(
        $scope, 
        $rootScope, 
        $location ,
        CartService
    ) {
        
    // DATA ..................    
    $scope.cart = {};
    $scope.products = {};
    $scope.message = '';
    $scope.errors = [];
    $scope.order_button = true;
    $scope.state = false;
    
    // LOAD ..................... 
    $scope.load = function () {
        CartService.get().then(
            function successCallback(response) {

                $scope.cart     = response.data.cart;
                $scope.products = response.data.cart.products;

                var count = 0;
                for(var A in $scope.products){
                    count++;
                    break;
                }
                if(count > 0){
                    $scope.state = true;
                }
                else{
                    $scope.state = false;
                }


            }, 
            function errorCallback(response) {}
        ); 
    };
    $scope.load();
        
       
    // BACK .....................    
    $scope.back = function () {
        $location.path("/");   
    };  
        
        
    // DELETE .....................    
    $scope.delete = function (id) {
        CartService.delete(id).then(
            function successCallback(response) {
                $scope.load();
            }, 
            function errorCallback(response) {}
        );
    };
        
        
    // ORDER .....................    
    $scope.order = function () {
        
        $scope.order_button = false;
        
       
        CartService.order({
            'names'   : $scope.cart.names,
            'email'   : $scope.cart.email,
            'address' : $scope.cart.address,
        }).then(
            function successCallback(response) {
                
                //.........................
                var result = response.data.result;
                
                //.........................
                if(result.errors.length > 0){
                    $scope.order_button = true;
                    $scope.errors = result.errors
                    return null;
                }
                
                //.........................
                $scope.state   = false;
                $scope.order_button = false;
                $scope.errors  = [];
                $scope.message = 'your order #'+result.order_id+' is complete!';
                
                
                
            }, 
            function errorCallback(response) {
                
                $scope.order_button = true;
                
                $scope.errors = [
                    'System error'
                ];
            }
        );
       
    };       
        
    
    
   
}]);

// CONTROLLERS/CART ........................................................




