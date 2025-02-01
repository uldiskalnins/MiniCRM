</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>


  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">




    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item "><a href="<?= base_url('crm/user/') ?>/<?= $user['id'] ?>"><?= $user['name'] ?> <?= $user['surname'] ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.edit') ?></li>
    </ul>

    <form action="<?= base_url('crm/save-user'); ?>" id="addForm" method="post">
      <?= csrf_field() ?>



      <div class="row pl-3 pr-3 pb-3">


        <div class="col-sm-12">

          <button type="submit" id="sbutton" class="btn btn-info btn-sm float-right"><i class='fas fa-save' style='font-size:12px'></i> <?= lang('Crm.save') ?></button>

        </div>

        <div class="container w-75 pb-3 pt-3">


          <div class="form-group ">
            <label for="name" class="small"><?= lang('Crm.name') ?>:</label>
            <input type="text" class="form-control" id="name" value="<?= $user['name'] ?>" name="name" maxlength="100" required>
          </div>

          <div class="form-group ">
            <label for="surname" class="small"><?= lang('Crm.surname') ?>:</label>
            <input type="text" class="form-control" id="surname" value="<?= $user['surname'] ?>" name="surname" maxlength="100" required>
          </div>



          <div class="form-group">
            <label for="email" class="small"><?= lang('Crm.email') ?>:</label>
            <input type="email" class="form-control" id="email" value="<?= $user['email'] ?>" name="email" maxlength="200" required>
          </div>

          <div class="form-group">
            <label for="title" class="small"><?= lang('Crm.phone'); ?>:</label>
            <input type="text" class="form-control" id="phone" value="<?= $user['phone'] ?>" name="phone" maxlength="100" required>
          </div>

          <div class="form-group">
            <label for="position" class="small"><?= lang('Crm.position') ?>:</label>
            <input type="text" class="form-control" id="position" value="<?= $user['position'] ?>" name="position" maxlength="100" required>
          </div>




          <div class="form-group">
            <label for="pwd" class="small"><?= lang('Crm.password') ?>: <span id="passHelp"><i class='far fa-question-circle' style='font-size:14px'></i></span> </label>
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="<?= lang('Crm.password') ?>" id="pwd" onkeyup="getPassword(this)" name="password" maxlength="100">
              <div class="input-group-append">
                <span class="input-group-text" id="showPass" onclick="togglePassword();"><i class='far fa-eye' style='font-size:18px'></i></span>
              </div>
            </div>
          </div>

          <div class="toast" data-autohide="false">
            <div class="toast-header">
              <strong class="mr-auto text-dark"><?= lang('Install.passRequirements') ?></strong> <button type="button" class="ml-2 mb-1 close float-right" data-dismiss="toast">&times;</button>
            </div>
            <div class="toast-body">
              <span id="plowercase"><?= lang('Install.passReqLL') ?></span><br>
              <span id="puppercase"><?= lang('Install.passReqUL') ?></span><br>
              <span id="pnumber"><?= lang('Install.passReqN') ?></span><br>
              <span id="pspecial"><?= lang('Install.passReqSS') ?></span><br>
              <span id="plength"><?= lang('Install.passReqSL') ?></span><br>
              <span id="pleveBlank"><b><?= lang('Crm.leaveBlankToNotChange') ?></b></span>
              
            </div>
          </div>

          <div class="form-group">
            <label for="pwd2" class="small"><?= lang('Crm.repeatPassword') ?>:</label>
            <input type="password" class="form-control" id="pwd2" onkeyup="comparePass();" placeholder="<?= lang('Crm.repeatPassword'); ?>" name="password2" size="100" maxlength="100" >
          </div>

        </div>



      </div>



    </form>

  </div>






  <script>
    $(document).ready(function() {

      $('.toast').toast('show');
      $("#passHelp").click(function() {
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
      togglePW.classList.contains('text-info') ? togglePW.classList.remove('text-info') : togglePW.classList.add('text-info');
    }
  </script>

  <script src="<?= base_url('assets/js/') ?>checkpw.js"></script>



</body>

</html>