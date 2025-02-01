</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">


    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('crm/activities/calls') ?>"><?= lang('Crm.calls') ?></a></li>
      <li class="breadcrumb-item active"><?= $callData['title'] ?></li>
    </ul>




    <div class="row pl-3 pr-3 pb-3 ">





      <div class="col-sm-12">


        <?= view('default/crm/crm_message_box.php') ?>

        <?php if (allowedToEdit($callData['user_id'])) : ?>
          <div class="pt-0 pb-0 float-right ">
            <a type="button" href="<?= base_url('crm/activities/call/edit') ?>/<?= $callData['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-pen" style="font-size:12px"></i> <?= lang('Crm.edit') ?></a>
          </div>

        <?php endif; ?>

      </div>

      <div class="col-sm-4 ">

        <div class="col-sm-12 ">
          <small class="text-muted"><?= lang('Crm.title') ?></small>
          <p><?= $callData['title'] ?></p>
        </div>

        <div class="col-sm-12">
          <small class="text-muted"><?= lang('Crm.type') ?></small>
          <p><?= lang('Crm.typeList')[$callData['type']] ?></p>
        </div>

        <div class="col-sm-12">
          <small class="text-muted"><?= lang('Crm.description') ?></small>
          <p><?= $callData['description'] ?></p>
        </div>

      </div>

      <div class="col-sm-4 ">

        <div class="col-sm-12">
          <small class="text-muted"><?= lang('Crm.status') ?></small>
          <p><?= lang('Crm.statusList')[$callData['status']] ?></p>
        </div>

        <div class="col-sm-12">
          <small class="text-muted"><?= lang('Crm.startDateTime') ?></small>
          <p><?= showDateAndTime($callData['start_date']) ?></p>
        </div>

        <div class="col-sm-12">
          <small class="text-muted"><?= lang('Crm.endDateTime') ?></small>
          <p><?= showDateAndTime($callData['end_date']) ?></p>
        </div>


      </div>

      <div class="col-sm-4 ">


        <div class="col-sm-12">
          <small class="text-muted"><?= lang('Crm.assignedUser') ?></small>
          <p><a href="<?= base_url('crm/user') ?>/<?= $callData['user_id'] ?>"><?= $callData['user_full_name'] ?></a></p>
        </div>

        <div class="col-sm-12">
          <small class="text-muted"><?= lang('Crm.parent') ?></small>

          <?php if (!empty($callData['parent_id'])) : ?>
            <p><a href="<?= base_url($allowedParents[$callData['parent_type']]['url']) ?><?= $callData['parent_id'] ?>"><?= $callData['parent_title'] ?></a></p>
          <?php endif; ?>
        </div>


        <?php if (!empty($secondaryParent['parent_id'])): ?>

          <div class="col-sm-12">
            <small class="text-muted"><?= lang('Crm.secondaryParentAccount') ?></small>

            <p><a href="<?= base_url($allowedParents[$secondaryParent['parent_type']]['url']) ?><?= $secondaryParent['parent_id'] ?>"><?= $secondaryParent['parent_title'] ?></a></p>

          </div>


        <?php endif; ?>


        <div class="col-sm-12"> <!---- DATUMI -->

          <small class="text-secondary"><?= lang('Crm.addDate') ?></small>
          <p><?= showDateAndTime($callData['creation_date'], 2) ?></p>

          <small class="text-secondary"><?= lang('Crm.editDate') ?></small>
          <p><?= showDateAndTime($callData['edit_date'], 2) ?></p>

        </div> <!---- BEIDZAS DATUMI -->

      </div>

      <div class="col-sm-12">

        <?= view_cell('\App\Controllers\crm\Viewcells::getActionHistory', ['id' => $callData['id'], 'type' => 4]) ?>

      </div>

    </div>



  </div>