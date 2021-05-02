<?php $this->extend('layout/main')?>

<?php echo $this->section('content') ?>
<div class="app" ng-app="app">
    <ng-view></ng-view>
</div>

<?php echo $this->endSection() ?>
        

         


