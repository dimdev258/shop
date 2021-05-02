
<div 
    class="cart_order" 
    ng-controller="CartController"
>
    

    
    <div class="wrapper" ng-if="state">
       
        <cart_order></cart_order>

        <div class="total" >
            <div class="label">Total: </div>
            <div class="value">{{cart.total}}</div>
            <div class="currency">lv.</div>
        </div>



        <div class="input_box">
            <label>names</label>
            <input 
                type="text" 
                ng-model="cart.names"
            >
        </div>

        <div class="input_box">
            <label>email</label>
            <input 
                type="text" 
                ng-model="cart.email"
            >
        </div>

        <div class="input_box">
            <label>address</label>
            <input 
                type="text" 
                ng-model="cart.address"
            >
        </div>


        <div class="buttons">

            <div 
                class="button_complete botton" 
                ng-click="order()"
                ng-if="order_button"
            >
                complete order
            </div>


            <div class="errors" ng-repeat="error in errors">
                <p class="error">{{error}}</p>
            </div>

        </div>
        
        
    </div>


    <div class="message" ng-if="message.length">
        {{message}}
    </div>
    
    <div class="back button_link" ng-click="back()">
        &lt; back to products
    </div>
   
</div>




