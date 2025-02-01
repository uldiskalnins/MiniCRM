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
  <li class="breadcrumb-item"><a href="<?= base_url('crm')?>" ><?= lang('Crm.crmTitle')?></a></li>
  <li class="breadcrumb-item"><a href="<?= base_url('admin')?>" ><?= lang('Crm.controlPanel')?></a></li>
  <li class="breadcrumb-item active"><?= lang('Crm.newUser')?></li>
 </ul>


<div class="container w-75 pb-3 pt-3">

<div class="text-danger">
<?= session()->getFlashdata('error'); ?>
<?= service('validation')->listErrors('my_list'); ?>
</div>


 <form action="<?= base_url('admin/new-user') ?>" id="saveForm" method="post">
 <?= csrf_field() ?>

  <div class="form-group">
   <label for="email"><?= lang('Crm.email');?></label>
   <input type="email" class="form-control" id="email" placeholder="<?= lang('Crm.email');?>" name="email" maxlength="200" required>
  </div>

  <div class="form-group">
   <label for="pwd"><?= lang('Crm.password');?> <span id="passHelp"><i class='far fa-question-circle' style='font-size:14px'></i></span> </label>
   <div class="input-group mb-3">
    <input type="password" class="form-control" placeholder="<?= lang('Crm.password');?>" id="pwd" onkeyup="getPassword(this)" name="password" maxlength="100" required>
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

  <div class="form-group">
   <label for="rights"><?= lang('Crm.userRightsLevel')?>:</label>
   <select class="form-control" id="rights" name="rights" required>


<?php
    $x = 0;

    while($x < count(lang('Crm.rightsLevelsWords')) ){

      echo '<option value="'.lang("Crm.rightsLevelsNumbers.$x").'">'.lang("Crm.rightsLevelsWords.$x")."</option>
      ";
      $x++;

    }
?>
   </select>
  </div>


  <button type="submit" id="sbutton" class="btn btn-info float-right"><?= lang('Install.create');?></button>

 </form>

<br>
</div>
</div>

<script>
    $(document).ready(function(){

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


    function togglePassword() {
        var passInput = document.getElementById('pwd');
        var togglePW = document.getElementById('showPass');
        passInput.type === "password" ? passInput.type = "text" : passInput.type = "password";
        togglePW.classList.contains('text-info') ? togglePW.classList.remove('text-info'): togglePW.classList.add('text-info');
    }


</script>

<script src="<?= base_url('/assets/js/checkpw.js')?>"></script>



</body>
</html>
