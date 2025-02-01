</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">


    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.controlPanel') ?></li>
    </ul>


    <div class="row pl-3 pr-3 pb-3">

      <div class="container col-md-10 offset-md-1 pt-4 pb-4">

      <div class="container w-75 text-center">
        <div class="list-group">
          <a href="<?= base_url('admin/users') ?>" class="list-group-item list-group-item-action"><?= lang('Crm.users') ?></a>
          <a href="<?= base_url('admin/crm-settings') ?>" class="list-group-item list-group-item-action"><?= lang('Crm.crmSettings') ?></a>
          <a href="<?= base_url('admin/email-settings') ?>" class="list-group-item list-group-item-action"><?= lang('Crm.emailSettings') ?></a>


        </div>
      </div>

    </div>


  </div>


</body>

</html>