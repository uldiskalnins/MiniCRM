<!DOCTYPE html>
<html lang="<?= $locale;?>">
<head>
 <title><?= lang('Crm.crmTitle').' - '. lang('Install.install');?></title>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
 <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>
<body class="bg-light text-dark" >

<nav class="navbar navbar-expand-md bg-dark navbar-dark ">
 <a class="navbar-brand" href="<?=base_url();?>">
  <?= lang('Crm.crmTitle');?>
 </a>


</nav>


<div class="container bg-white pb-5  mt-3 mb-3 pl-0 pr-0 border">
 <ul class="breadcrumb rounded-0 text-white bg-success pb-2 pt-2">
  <li class="breadcrumb-item "><?= lang('Install.installComplete') ;?></li>
 </ul>
 <div class="container w-75 pb-3 pt-3 text-center">


  <div class="container  mb-3 p-3">
   <h4><?= lang('Install.installComplete') ;?></h4>
    <p class="pt-3">
    <b><?= lang('Install.adminEmail') .':</b><br> <span class="lead">'. $adminEmail ;?></span><br>
    <b><?= lang('Install.adminPass') .':</b><br> <span class="lead">'. $adminPass ;?></span><br>
    
    </p>
  </div>

  <a type="button" href="<?= base_url();?>" class="btn btn-success "><?= lang('Crm.login');?></a>


 </div>
</div>


</body>
</html>