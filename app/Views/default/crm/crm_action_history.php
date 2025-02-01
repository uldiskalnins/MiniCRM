</head>

<body class="bg-light text-dark">

  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">

    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item"><a href="<?= $linkBaseUrl . $recordId ?>"><?= $linkTitle ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.actionHistory') ?></li>
    </ul>

    <div class="row pl-3 pr-3 pb-3 ">

      <div class="col-sm-12">

        <div class="card w-100 rounded-0 border-0 ">
          <div class="card-body p-1 table-responsive-md">

            <table class="table table-sm table-hover ">
              <thead class="thead-light">
                <tr>

                  <th class="small text-muted text-secondary col-sm-8"><?= lang('Crm.action') ?></th>
                  <th class="small text-muted col-sm-2"><?= lang('Crm.user') ?></th>
                  <th class="small text-muted col-sm-2"><?= lang('Crm.date') ?></th>
                </tr>
              </thead>
              <tbody>

                <?php
                if (is_array($historyList)) {

                  foreach ($historyList as $hl) {
                    echo '
                      <tr>
                      <td class="small">' . $actionHistoryLog->decodeData($hl) . '</td>
                      <td class="small"><a href="' . base_url('crm/user/') . $hl->user_id  . '">' . $hl->user_full_name . '</a></td>
                      <td class="small">' . showDateAndTime($hl->creation_date) . '</td>
                      </tr>
                    ';
                  }
                }

                ?>

              </tbody>
            </table>

            <div class="m-2"><?= $pager_links ?></div>

          </div>

        </div>

      </div>

    </div>
  </div>