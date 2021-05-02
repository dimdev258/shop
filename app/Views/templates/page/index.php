

<div 
    class="cart_notification"
    ng-controller="CartNotificationController" 
>
   <cart_notification></cart_notification>
</div>




<div 
    class="products" 
    ng-controller="ProductsController"
>

    <select 
        class="category_input" 
        ng-model="category_id"
        ng-change="filtrate()"
    >        
        <option 
            ng-repeat="category in categories"  
            ng-value="category.id"
        >
            {{category.name}}
        </option>
        
    ></select>
        
    

    <input 
        class="search_input" 
        type="text" 
        ng-model="search"
    >

    <div 
        class="search_button botton" 
        ng-click="filtrate()" 
    >search</div>
    
   

    <products-iterate></products-iterate>

</div>
    

