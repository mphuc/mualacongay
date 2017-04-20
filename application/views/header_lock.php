<?php
define('data_url',         base_url().'application/data/');
define('dataadmin_url',    base_url().'application/data/admin/');
 
?>
<html>
<head>
    <title><?=$title?></title> 
    <meta charset="utf-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?=data_url?>img/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="<?=data_url?>shop/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=data_url?>shop/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=data_url?>shop/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=data_url?>shop/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?=data_url?>shop/css/jquery-ui.min.css">
    <link rel="stylesheet" href="<?=data_url?>shop/css/jquery.fancybox.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?=data_url?>shop/css/style.css">
    <link rel="stylesheet" href="<?=data_url?>shop/css/responsive.css">
    
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Archivo+Narrow:400,700%7cPathway+Gothic+One" rel="stylesheet"> 
    <link rel="stylesheet" href="<?=data_url?>css/customer.css">
     <script type="text/javascript" src="<?=data_url?>js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="<?=data_url?>js/bootstrap.js"></script> 
    
    <script src="<?=data_url?>js/owlcarousel/owl.carousel.js"></script>
    <script type="text/javascript">
        function imgError(image) {
            image.onerror = "";
            image.src = dataadmin_url + 'img/notFound.png';
            return true;
        }
    </script>
</head>

<body style="background: #000000"> 
    