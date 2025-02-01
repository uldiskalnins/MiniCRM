

</head>

<body class="bg-light text-dark">

  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">

    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle'); ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.opportunities'); ?></li>
    </ul>

    <div class="row pl-3 pr-3 pb-3 ">

      <div class="col-sm-12">

        <?= view('default/crm/crm_message_box.php') ?>

        <div class="row ">

          <div class="col-sm-4 ">
            <div class="form-group">


              <div class="input-group mb-0">
                <input id="findOpportunity" type="text" placeholder="<?= lang('Crm.title') ?>" class="form-control  form-control-sm" autocomplete="off">

              </div>
              <div class="font-weight-lighter" id="resultOpportunity"></div>
            </div>

          </div>
          <div class="col-sm-8 ">

            <div class="pt-1 pb-3 pr-1 float-right ">
              <a type="button" href="<?= base_url('crm/opportunities/new'); ?>" class="btn btn-success btn-sm"><i class='far fas fa-plus' style='font-size:12px'></i> <?= lang('Crm.createNew') ?> </a>
            </div>

          </div>
        </div>

        <div class="card w-100 rounded-0 border-0 ">
          <div class="card-body p-1 table-responsive-md">

            <table class="table table-sm table-hover">
              <thead class="thead-light">
                <tr>
                  <th class="small col-sm-3"><?= lang('Crm.title') ?></th>
                  <th class="small col-sm-2"><?= lang('Crm.parent') ?></th>
                  <th class="small col-sm-2"><?= lang('Crm.stage') ?></th>
                  <th class="small col-sm-2"><?= lang('Crm.amount') ?></th>
                  <th class="small col-sm-3"><?= lang('Crm.user') ?></th>
                </tr>
              </thead>

              <tbody>

                <?php
                if (is_array($leads)) {
                  foreach ($leads as $row) {

                    echo '
                      <tr>
                      <td><a class="active-' . $row->active . '" href="' . base_url('crm/opportunity/') . $row->id. '" >' . $row->title . '</a></td>
                      <td><a class="active-' . $row->parent_active . '" href="' . base_url($allowedParents[$row->parent_type]['url']) . $row->parent_id . '" >' . $row->parent_title . '</a></td>
                      <td>' . lang('Crm.opportunityStageList')[$row->stage] . '</td>
                      <td>' . showMoney($row->amount, $row->currency) . '</td>
                      <td><a href="' . base_url('crm/user') . '/' . $row->user_id . '">' .$row ->user_full_name . '</a></td>
                      </tr>
                    ';
                  }
                }

                ?>

              </tbody>
            </table>

            <div class="m-2">
              <div class="float-left pt-1">
              <?= $pager_links ?>
              </div>
            </div>

          </div>

        </div>

      </div>

    </div>
  </div>



  <script>
    var findOpportunityUrl = "<?= base_url('ajax/search-opportunity') ?>";
  </script>
