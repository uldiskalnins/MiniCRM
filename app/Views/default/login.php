
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



<div class="row">

<div class="container col-10 col-sm-8 col-md-8 col-lg-4 col-xl-4 text-dark bg-white pb-3  mt-3 mb-3 pl-0 pr-0 border">

 <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2">
  <li class="breadcrumb-item "><?= lang('Crm.login');?></li>
 </ul>


<div class="container w-100 pb-3 pt-2">




<div class="text-danger">
<?= session()->getFlashdata('error') ?>
<?= service('validation')->listErrors('my_list') ?>
</div>



 <form action="<?= base_url('login'); ?>" method="post">
 <?= csrf_field() ?>

  <div class="form-group">
   <label for="email"><?= lang('Crm.email');?></label>
   <input type="email" class="form-control" id="email" placeholder="<?= lang('Crm.email');?>" name="email" maxlength="200" required>
  </div>

  <div class="form-group pb-2">
   <label for="pwd"><?= lang('Crm.password');?></label>
   <div class="input-group mb-3">
    <input type="password" class="form-control" placeholder="<?= lang('Crm.password');?>" id="pwd" name="password" maxlength="100" required>
    <div class="input-group-append">
     <span class="input-group-text" id="showPass" onclick="togglePassword();"><i class='far fa-eye' style='font-size:18px'></i></span>
    </div>
   </div>
  </div>


  <button type="submit" id="sbutton" class="btn btn-info float-right"><?= lang('Crm.login');?></button>

 </form>


</div>
</div>

</div>

<footer class="page-footer mt-5 border border-top-1 border-bottom-0">

 <div class="footer-copyright text-center text-secondary py-3">© <?= lang('Crm.crmTitle');?>
 </div>
</footer>


<script>


    function togglePassword() {
        var passInput = document.getElementById('pwd');
        var togglePW = document.getElementById('showPass');
        passInput.type === "password" ? passInput.type = "text" : passInput.type = "password";
        togglePW.classList.contains('text-info') ? togglePW.classList.remove('text-info'): togglePW.classList.add('text-info');
    }


</script>





</body>
</html>
