<style>

</style>
</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">


    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle'); ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.meetings'); ?></li>
    </ul>


    <div class="row pl-3 pr-3 pb-3 ">

      <div class="col-sm-12">

        <div class="float-right mr-1">
          <a type="button" title="<?= lang('Crm.newMeeting') ?>" class="btn btn-light pl-3" href="<?= base_url('crm/activities/meetings/new') ?>"><i class='far fa-calendar-alt' style='font-size:12px'></i></a>
        </div>
        <?= view('default/crm/crm_message_box.php') ?>

        <div class="row ">


        </div>


        <div class="card w-100 rounded-0 border-0 ">
          <div class="card-body p-1 table-responsive-md">

            <table class="table table-sm table-hover">
              <thead class="thead-light">
                <tr>

                  <th class="small"><?= lang('Crm.title') ?></th>
                  <th class="small"><?= lang('Crm.beginning') ?></th>
                  <th class="small"><?= lang('Crm.status') ?></th>
                  <th class="small"><?= lang('Crm.parent') ?></th>
                  <th class="small"><?= lang('Crm.user') ?></th>

                </tr>
              </thead>

              <tbody>

                <?php
                if (is_array($meetings)) {
                  foreach ($meetings as $ml) {

                    echo '
                      <tr>
                      <td><a href="' . base_url('crm/activities/meeting') . '/' . $ml->id . '" >' . $ml->title . '</a></td>
                      <td>' . showDateAndTime($ml->start_date) . '</td>
                      <td>' . lang('Crm.statusList')[$ml->status] . '</td>
                      <td><a href="' . base_url($allowedParents[$ml->parent_type]['url']) . $ml->parent_id . '" >' . $ml->parent_title . '</a></td>
                      <td><a href="' . base_url('crm/user') . '/' . $ml->user_id . '" >' . $ml->user_full_name . '</a></td>
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