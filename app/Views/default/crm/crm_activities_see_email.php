</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">


    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('crm/activities/emails') ?>"><?= lang('Crm.emails') ?></a></li>
      <li class="breadcrumb-item active"><?= $emailData['subject'] ?></li>
    </ul>


    <div class="row pl-3 pr-3 pb-3 ">

      <?php if (allowedToEdit($emailData['user_id'])) : ?>

        <div class="col-sm-12">

          <?= view('default/crm/crm_message_box.php') ?>

          <div class="pt-0 pb-0 float-right ">
            <a type="button" href="<?= base_url('crm/activities/emails/edit') ?>/<?= $emailData['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-pen" style="font-size:12px"></i> <?= lang('Crm.edit') ?></a>
          </div>

        <?php endif; ?>

        </div>


        <div class="col-sm-8 row">

          <div class="col-sm-6 ">

            <div class="col-sm-12 ">
              <small class="text-muted"><?= lang('Crm.fromEmail') ?>:</small>
              <p><?= $emailData['from_email'] ?></p>
            </div>


            <div class="col-sm-12">
              <small class="text-muted"><?= lang('Crm.ccEmail') ?>:</small>
              <p><?= $emailData['cc'] ?></p>
            </div>


          </div>


          <div class="col-sm-6 ">

            <div class="col-sm-12 ">
              <small class="text-muted"><?= lang('Crm.toEmail') ?>:</small>
              <p><?= $emailData['to_email'] ?></p>
            </div>

            <div class="col-sm-12">
              <small class="text-muted"><?= lang('Crm.bccEmail') ?>:</small>
              <p><?= $emailData['bcc'] ?></p>
            </div>


          </div>




          <div class="col-sm-12 ">
            <hr>

            <div class="col-sm-12 mb-2">
              <small class="text-muted"><?= lang('Crm.emailSubject') ?></small>
              <p><?= $emailData['subject'] ?></p>
            </div>

            <hr>

            <div class="col-sm-12 ">
              <small class="text-muted"><?= lang('Crm.emailBody') ?>:</small>
              <p><?= $emailData['body'] ?></p>
            </div>
            <hr>



            <?php

            if (!empty($emailFiles)) {

              echo '
                  <div class="col-sm-12 ">
                  <small class="text-muted">' . lang('Crm.files') . ':</small>

                  <table class="table table-borderless table-sm">
                  <tbody>
                  ';

              foreach ($emailFiles as $file) {
                $shortFileName = shortEmailFileName($file['file_name']);
                echo '<tr><td><i style="font-size:16px" class="fas">&#xf0c6;</i> <a href="' . base_url('/uploads/email/') . $file['file_name'] . '" download="' . $shortFileName . '">' . $shortFileName . '</a></td></tr>';
              }

              echo '</tbody>
                  </table>
                  </div>
                  <hr>
                  ';
            }


            ?>

          </div>

          <div class="col-sm-12">

            <?= view_cell('\App\Controllers\crm\Viewcells::getActionHistory', ['id' => $emailData['id'], 'type' => 6]) ?>

          </div>


        </div>

        <div class="col-sm-4 ">

          <div class="col-sm-12">
            <small class="text-muted"><?= lang('Crm.emailAction') ?>:</small>
            <p><?= lang('Crm.emailActionList')[$emailData['action_type']] ?></p>
          </div>

          <?php if (!empty($emailData['user_id'])) : ?>
            <div class="col-sm-12">
              <small class="text-muted"><?= lang('Crm.assignedUser') ?>:</small>
              <p><a href="<?= base_url('crm/user') ?>/<?= $emailData['user_id'] ?>"><?= $emailData['user_full_name'] ?></a></p>
            </div>
          <?php endif; ?>




          <?php if (!empty($emailData['parent_id'])) : ?>

            <div class="col-sm-12">
              <small class="text-muted"><?= lang('Crm.parent') ?></small>

              <p><a href="<?= base_url($allowedParents[$emailData['parent_type']]['url'])?><?= $emailData['parent_id'] ?>"><?= $emailData['parent_title'] ?></a></p>

            </div>


          <?php endif; ?>


          <div class="col-sm-12"> <!---- DATUMI -->

            <small class="text-secondary"><?= lang('Crm.addDate') ?></small>
            <p><?= showDateAndTime($emailData['creation_date'], 2) ?></p>

            <small class="text-secondary"><?= lang('Crm.editDate') ?></small>
            <p><?= showDateAndTime($emailData['edit_date'], 2) ?></p>

          </div> <!---- BEIDZAS DATUMI -->

        </div>



    </div>



  </div>