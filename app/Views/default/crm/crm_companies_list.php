</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">

    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle'); ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.companies'); ?></li>
    </ul>


    <div class="row pl-3 pr-3 pb-3 ">

      <div class="col-sm-12">

        <?= view('default/crm/crm_message_box.php') ?>

        <div class="row ">

          <div class="col-sm-4 ">
            <div class="form-group">

              <div class="input-group mb-0">
                <input id="findAccount" type="text" placeholder="<?= lang('Crm.writeCompanyTitle') ?>" class="form-control  form-control-sm" autocomplete="off">

              </div>
              <div class="font-weight-lighter" id="resultAccount"></div>
            </div>

          </div>
          <div class="col-sm-8 ">

            <div class="pt-1 pb-3 pr-1 float-right ">
              <a type="button" href="<?= base_url('crm/companies/new'); ?>" class="btn btn-success btn-sm"><i class='far fas fa-plus' style='font-size:12px'></i> <?= lang('Crm.createNew') ?></a>
            </div>

          </div>
        </div>

        
        <div class="card w-100 rounded-0 border-0 ">
          <div class="card-body p-1 table-responsive-md">

            <table class="table table-sm table-hover">
              <thead class="thead-light">
                <tr>
                  <th class="small col-sm-3"><?= lang('Crm.title') ?></th>
                  <th class="small col-sm-3"><?= lang('Crm.email') ?></th>
                  <th class="small col-sm-3"><?= lang('Crm.phone') ?></th>
                  <th class="small col-sm-3"><?= lang('Crm.user') ?></th>
                </tr>
              </thead>

              <tbody>
                <?php
                if (is_array($companies)) {
                  foreach ($companies as $row) 
                  {
                    echo '
                    <tr>
                    <td ><a class="active-' . $row['active'] . '" href="' . base_url('crm/company') . '/' . $row['id'] . '" >' . $row['title'] . '</a></td>
                    <td ><a href="' . base_url('crm/activities/emails/new?companyid=') . $row['id'] . '">' . $row['email'] . '</a></td>
                    <td ><a href="' . base_url('crm/activities/calls/new?companyid=') . $row['id'] . '">' . $row['phone'] . '</a></td>
                    <td ><a class="" href="' . base_url('crm/user/'). $row['user_id'] . '" >' . $row['user_full_name'] . '</a></td>
                    ';
                  }

                  echo '  </tr>';
                }

                ?>

              </tbody>
            </table>

            <div class="m-2">
              <div class="float-left pt-1">
                <?php if ($pager) : ?>
                  <?php $pager->setPath(uri_string()) ?>
                  <?= $pager->links('group1', 'my_pagination') ?>
                <?php endif ?>
              </div>
            </div>

          </div>

        </div>

      </div>

    </div>
  </div>


  <script>
    var findAccountUrl = "<?= base_url('ajax/search-account') ?>";
  </script>
