</head>

<body class="bg-light text-dark">

  <?= view('default/crm/navbar.php') ?>


  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">

    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item "><a href="<?= base_url('admin/') ?>"><?= lang('Crm.controlPanel') ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.emailSettings') ?></li>

    </ul>

    <?= view('default/crm/crm_message_box.php') ?>

    <form action="<?= base_url('admin/email-settings'); ?>" id="addForm" method="post">
      <?= csrf_field() ?>



      <div class="row pl-3 pr-3 pb-3">


        <div class="col-sm-12">

          <button type="submit" id="sbutton" class="btn btn-info btn-sm float-right"><i class='fas fa-save' style='font-size:12px'></i> <?= lang('Crm.save') ?></button>

        </div>


        <div class="container w-75 pb-3 pt-3">

          <div class="form-group">
            <label for="smtpprotocol" class="small"><?= lang('Crm.smtpProtocol') ?>:</label>
            <select class="form-control" id="smtpprotocol" name="smtpprotocol">

              <?php
              echo '<option value="0" ' . ($useSmtp == 0 ? "selected" : "") . '>' . lang('Crm.smtpProtocolMail') . '</option>
              <option value="1" ' . ($useSmtp == 1  ? "selected" : "") . '>' . lang('Crm.smtpProtocolSmtp') . '</option>
              ';
              ?>

            </select>
          </div>


          <div class="form-group ">
            <label for="smtpserver" class="small"><?= lang('Crm.smtpHost') ?>:</label>
            <input type="text" class="form-control" id="smtpserver" value="<?= $SMTPHost ?>" name="smtpserver" maxlength="100">
          </div>

          <div class="form-group ">
            <label for="smtpuser" class="small"><?= lang('Crm.smtpUser') ?>:</label>
            <input type="text" class="form-control" id="smtpuser" value="<?= $SMTPUser ?>" name="smtpuser" maxlength="100">
          </div>

          <div class="form-group">
            <label for="pwd" class="small"><?= lang('Crm.smtpPass') ?>: </label>
            <div class="input-group mb-3">
              <input type="password" class="form-control" id="pwd" name="smtppass" value="<?= $SMTPPass ?>" maxlength="300">
              <div class="input-group-append">
                <span class="input-group-text" id="showPass" onclick="togglePassword('pwd','showPass');"><i class='far fa-eye' style='font-size:18px'></i></span>
              </div>
            </div>
          </div>

          <div class="form-group ">
            <label for="smtpport" class="small"><?= lang('Crm.smtpPort') ?>:</label>
            <input type="text" class="form-control" id="smtpport" value="<?= $SMTPPort ?>" name="smtpport" maxlength="5">
          </div>

          <div class="form-group">
            <label for="smtpcrypto" class="small"><?= lang('Crm.smtpCrypto') ?>:</label>
            <select class="form-control" id="smtpcrypto" name="smtpcrypto">
              <?php
              echo '
                <option value="" ' . ($SMTPCrypto == "" ? "selected" : "") . '>' . lang('Crm.smtpCryptoNone') . '</option>
                <option value="ssl" ' . ($SMTPCrypto == "ssl" ? "selected" : "") . '>' . lang('Crm.smtpCryptoSsl') . '</option>
                <option value="tls" ' . ($SMTPCrypto == "tls" ? "selected" : "") . '>' . lang('Crm.smtpCryptoTls') . '</option>
                ';

              ?>

            </select>
            <br>
          </div>

        </div>

      </div>

  </div>


</body>

<script>
  function togglePassword(passId, toggleId) { //parāda vai slēpj paroles lauciņa tekstu
    var passInput = document.getElementById(passId);
    var togglePW = document.getElementById(toggleId);
    passInput.type === "password" ? passInput.type = "text" : passInput.type = "password";
    togglePW.classList.contains('text-info') ? togglePW.classList.remove('text-info') : togglePW.classList.add('text-info');
  }
</script>

</html>