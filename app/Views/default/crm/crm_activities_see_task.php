
</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">


    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('crm/activities/tasks') ?>"><?= lang('Crm.tasks') ?></a></li>
      <li class="breadcrumb-item active"><?= $taskData['title'] ?></li>
    </ul>




    <div class="row pl-3 pr-3 pb-3 ">



      <div class="col-sm-12">


        <?= view('default/crm/crm_message_box.php') ?>

        <?php if (allowedToEdit($taskData['user_id'])) : ?>

          <div class="pt-0 pb-0 float-right ">
            <a type="button" href="<?= base_url('crm/activities/task/edit') ?>/<?= $taskData['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-pen" style="font-size:12px"></i> <?= lang('Crm.edit') ?></a>
          </div>

        <?php endif; ?>

      </div>

      <div class="col-sm-4 ">


        <div class="col-sm-12 ">
          <small class="text-muted"><?= lang('Crm.title') ?></small>
          <p><?= $taskData['title'] ?></p>
        </div>


        <div class="col-sm-12">
          <small class="text-muted"><?= lang('Crm.priority') ?></small>
          <p><?= lang('Crm.taskPriorityList')[$taskData['priority']] ?></p>
        </div>


        <div class="col-sm-12">
          <small class="text-muted"><?= lang('Crm.description') ?></small>
          <p><?= $taskData['description'] ?></p>
        </div>


      </div>


      <div class="col-sm-4 ">


        <div class="col-sm-12">
          <small class="text-muted"><?= lang('Crm.status') ?></small>
          <p><?= lang('Crm.taskStatusList')[$taskData['status']] ?></p>
        </div>


        <div class="col-sm-12">
          <small class="text-muted"><?= lang('Crm.startDateTime') ?></small>
          <p><?php if (!empty($taskData['start_date'])) {
                echo showDateAndTime($taskData['start_date']);
              } ?></p>
        </div>


        <div class="col-sm-12">
          <small class="text-muted"><?= lang('Crm.endDateTime') ?></small>
          <p><?php if (!empty($taskData['end_date'])) {
                echo showDateAndTime($taskData['end_date']);
              } ?></p>
        </div>


      </div>

      <div class="col-sm-4 ">


        <div class="col-sm-12">
          <small class="text-muted"><?= lang('Crm.assignedUser') ?></small>
          <p><a href="<?= base_url('crm/user') ?>/<?= $taskData['user_id'] ?>"><?= $taskData['user_full_name'] ?></a></p>
        </div>

        <div class="col-sm-12">
          <small class="text-muted"><?= lang('Crm.parent') ?></small>


          <?php if (!empty($taskData['parent_id'])) : ?>
            <p><a href="<?= base_url($allowedParents[$taskData['parent_type']]['url'])?><?= $taskData['parent_id'] ?>"><?= $taskData['parent_title'] ?></a></p>
          <?php endif; ?>
        </div>


        <div class="col-sm-12"> <!---- DATUMI -->

          <small class="text-secondary"><?= lang('Crm.addDate') ?></small>
          <p><?= showDateAndTime($taskData['creation_date'], 2) ?></p>

          <small class="text-secondary"><?= lang('Crm.editDate') ?></small>
          <p><?= showDateAndTime($taskData['edit_date'], 2) ?></p>

        </div> <!---- BEIDZAS DATUMI -->

      </div>

      <div class="col-sm-12">

        <?= view_cell('\App\Controllers\crm\Viewcells::getActionHistory', ['id' => $taskData['id'], 'type' => 7]) ?>

      </div>

    </div>



  </div>