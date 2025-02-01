<style>

</style>
</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">


    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle'); ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.emails'); ?></li>
    </ul>


    <div class="row pl-3 pr-3 pb-3 ">

      <div class="col-sm-12">

        <div class="float-right mr-1">
          <a type="button" title="<?= lang('Crm.newEmail') ?>" class="btn btn-light" href="<?= base_url('crm/activities/emails/new') ?>"><i class='far fa-envelope' style='font-size:12px'></i></a>
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
                  <th class="small"><?= lang('Crm.addDate') ?></th>
                  <th class="small"><?= lang('Crm.emailAction') ?></th>
                  <th class="small"><?= lang('Crm.parent') ?></th>
                  <th class="small"><?= lang('Crm.user') ?></th>

                </tr>
              </thead>

              <tbody>

                <?php
                if (is_array($emails)) {
                  foreach ($emails as $email) {

                    echo '
                      <tr>
                        <td><a href="' . base_url('crm/activities/email') . '/' . $email->id . '" >' . $email->subject . '</a></td>
                        <td>' . showDateAndTime($email->creation_date) . '</td>
                        <td>' . lang('Crm.emailActionList')[$email->action_type] . '</td>
                        <td><a href="' . base_url($allowedParents[$email->parent_type]['url']) . $email->parent_id . '" >' . $email->parent_title . '</a></td>
                        <td><a href="' . base_url('crm/user') . '/' . $email->user_id . '" >' . $email->user_full_name . '</a></td>
                      </tr> ';
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