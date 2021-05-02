<div ng-repeat="item in products">
    
    <div class="product">
        
        <div class="name">{{item.name}}</div>
         
        <div 
            class="image"
            style="
               background-image: url(product_images/{{item.photo}});
            "
        ></div>
        
        <div class="price" ng-hide="item.sum">
            <div class="label">price:</div>
            <div class="value">{{item.price}}</div>
            <div class="currency"> lv.</div>
        </div>
        
        <div class="buy botton" ng-click="buy(item.id)" ng-hide="item.sum">buy</div>
        
        
        
        <table class="sum" ng-show="item.sum">
            
            <tr>
                <th>price</th>
                <th>quantity</th>
                <th>sum</th>
                <th></th>
            </tr>
            
            <tr>
                <td>{{item.price}} lv.</td>
                <td>{{item.quantity}}</td>
                <td>{{item.sum}} lv.</td>
                <td>
                    <div 
                        class="delete"
                        ng-click="delete(item.id)"
                    ></div>
                    
                </td>
            </tr>
            
        </table>
        
    </div>
    
</div>