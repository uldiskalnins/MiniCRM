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
 <a class="navbar-brand" href="<?= base_url(); ?>">
  <?= lang('Crm.crmTitle');?>
 </a>

 <div class="collapse navbar-collapse" id="collapsibleNavbar">
  <ul class="navbar-nav">

  </ul>
 </div>
</nav>





<div class="container text-dark pb-5 bg-white mt-3 mb-3 pl-0 pr-0 border">

 <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2">
  <li class="breadcrumb-item"><?= lang('Crm.crmTitle');?></li>
  <li class="breadcrumb-item active"><?= lang('Install.install');?></li>
 </ul>


<div class="container w-75 pb-3 pt-3">

<div class="text-danger">
<?= session()->getFlashdata('error'); ?>
<?= service('validation')->listErrors('my_list'); ?>



</div>



 <form action="<?= base_url('install/ok'); ?>" id="installForm" method="post">
 <?= csrf_field() ?>

  <div class="form-group">
   <label for="email"><?= lang('Install.adminEmail');?></label>
   <input type="email" class="form-control" id="email" placeholder="<?= lang('Install.adminEmail');?>" name="email" maxlength="200" required>
  </div>

  <div class="form-group">
   <label for="pwd"><?= lang('Install.adminPass');?> <span id="passHelp"><i class='far fa-question-circle' style='font-size:14px'></i></span> </label>
   <div class="input-group mb-3">
    <input type="password" class="form-control" placeholder="<?= lang('Install.adminPass');?>" id="pwd" onkeyup="getPassword(this)" name="password" maxlength="100" required>
    <div class="input-group-append">
     <span class="input-group-text" id="showPass" onclick="togglePassword();"><i class='far fa-eye' style='font-size:18px'></i></span>
    </div>
   </div>
  </div>

  <div class="toast" data-autohide="false">
   <div class="toast-header">
    <strong class="mr-auto text-dark"><?= lang('Install.passRequirements');?></strong> <button type="button" class="ml-2 mb-1 close float-right" data-dismiss="toast">&times;</button>
   </div>
   <div class="toast-body">
    <span id="plowercase"><?= lang('Install.passReqLL');?></span><br>
    <span id="puppercase"><?= lang('Install.passReqUL');?></span><br>
    <span id="pnumber"><?= lang('Install.passReqN');?></span><br>
    <span id ="pspecial"><?= lang('Install.passReqSS');?></span><br>
    <span id="plength"><?= lang('Install.passReqSL');?></span>
   </div>
  </div>

  <div class="form-group">
   <label for="pwd2"><?= lang('Install.repeatAdminPass');?></label>
   <input type="password" class="form-control" id="pwd2" onkeyup="comparePass();" placeholder="<?= lang('Install.repeatAdminPass');?>" name="password2" size="100" required>
  </div>

  <div class="form-group ">
   <label for="name"><?= lang('Crm.name');?></label>
   <input type="text" class="form-control" id="name" placeholder="<?= lang('Crm.name');?>" name="name" maxlength="100" required>
  </div>

  <div class="form-group ">
   <label for="surname"><?= lang('Crm.surname');?></label>
   <input type="text" class="form-control" id="surname" placeholder="<?= lang('Crm.surname');?>" name="surname" maxlength="100" required>
  </div>

  <div class="form-group">
   <label for="title"><?= lang('Crm.phone');?></label>
   <input type="text" class="form-control" id="phone" placeholder="<?= lang('Crm.phone');?>" name="phone" maxlength="100" required>
  </div>

  <div class="form-group">
   <label for="title"><?= lang('Crm.position');?></label>
   <input type="text" class="form-control" id="position" placeholder="<?= lang('Crm.position');?>" name="position" maxlength="100" required>
  </div>

  <button type="submit" id="sbutton" class="btn btn-info float-right"><?= lang('Install.create');?></button>

 </form>

<br>
</div>
</div>

<script>
    $(document).ready(function(){

        $("#installForm").submit(function () {
            $(".sbutton").attr("disabled", true);
            return true;
        });

        $('.toast').toast('show');
        $("#passHelp").click(function(){
            $('.toast').toast('show');
        });
    });

    var submitButton = document.getElementById('sbutton');
    var pLength = document.getElementById('plength');
    var pLowercase = document.getElementById('plowercase');
    var pUppercase = document.getElementById('puppercase');
    var pNumber = document.getElementById('pnumber');
    var pSpecial = document.getElementById('pspecial');


    function togglePassword() {//parāda vai slēpj pirmās paroles lauciņa tekstu
        var passInput = document.getElementById('pwd');
        var togglePW = document.getElementById('showPass');
        passInput.type === "password" ? passInput.type = "text" : passInput.type = "password";
        togglePW.classList.contains('text-info') ? togglePW.classList.remove('text-info'): togglePW.classList.add('text-info');
    }

    function comparePass(){//salīdzina pirmo un otro paroli

        var pass1 = document.getElementById('pwd');
        var pass2 = document.getElementById('pwd2');
        if (pass1.value == pass2.value){pass2.classList.add('border-info');}
        else{pass2.classList.remove('border-info');}
    }

</script>

<script src="<?= base_url('')?>/assets/js/checkpw.js"></script>



</body>
</html>
