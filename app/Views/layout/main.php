<!DOCTYPE html>
<html lang="en" >
<head>

    <meta charset="UTF-8">
    <title>Shop</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="<?php echo base_url('/css/global.css')?>" type="text/css" />

    <style>
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
          display: none !important;
        }
    </style>

</head>
<body>
    
    <?php echo $this->renderSection('content')?>
    
    <script src="<?php echo base_url('/js/angular.js')?>"></script>
    <script src="<?php echo base_url('/js/angular-route.js')?>"></script>
    <script src="<?php echo base_url('/js/app.js')?>"></script>
    
</body>
</html>