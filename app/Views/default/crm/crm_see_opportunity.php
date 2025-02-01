</head>

<body class="bg-light text-dark">

  <?= view('default/crm/navbar.php') ?>

  <div class="container col-11 text-dark bg-white mt-3 border pl-0 pr-0">
    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item "><a href="<?= base_url('crm/opportunities/') ?>"><?= lang('Crm.opportunities') ?></a></li>
      <li class="breadcrumb-item active"><?= $opportunityData['title'] ?></li>
    </ul>


    <div class="row pl-3 pr-3 pb-3">

      <div class="col-sm-12">

        <?= view('default/crm/crm_message_box.php') ?>

        <div class="btn-group float-right pt-0 pb-0 ">
          <a type="button" href="<?= base_url('crm/opportunity/edit') ?>/<?= $opportunityData['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-pen" style="font-size:12px"></i> <?= lang('Crm.edit') ?> </a>
          <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
            <span class="caret"></span>
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <?php if ($opportunityData['active'] == 1) : ?>
              <a class="dropdown-item delete-link" data-confirm-message="<?= lang('Crm.delete') ?>?" href="<?= base_url('crm/delete-record/') ?><?= $opportunityData['id'] . '/8' ?>"><i class="fas fa-trash" style="font-size:12px"></i> <?= lang('Crm.delete') ?> </a>
            <?php else : ?>
              <a class="dropdown-item delete-link" data-confirm-message="<?= lang('Crm.undelete') ?>?" href="<?= base_url('crm/delete-record/') ?><?= $opportunityData['id'] . '/8' ?>"><i class="fas fa-check" style="font-size:12px"></i> <?= lang('Crm.undelete') ?> </a>
            <?php endif; ?>
          </div>
        </div>
      </div>


      <div class="col-sm-12 col-md-9 col-lg-9">

        <div class="row pb-3"> <!----  PAMATINFO  -->

          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class=" text-muted border-bottom border-light"><?= lang('Crm.title') ?></small>
            <p class="active-<?= $opportunityData['active'] ?>"><?= $opportunityData['title']  ?></p>
          </div>

          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class=" text-muted border-bottom border-light"><?= lang('Crm.stage') ?></small>
            <p class=""><?=  lang('Crm.opportunityStageList')[$opportunityData['stage'] ] ?></p>
          </div>

          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.parent') ?></small>
            <p><a href="<?= base_url($allowedParents[$opportunityData['parent_type']]['url'])?><?= $opportunityData['parent_id'] ?>"><?= $opportunityData['parent_title'] ?></a></p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <small class="text-muted"><?= lang('Crm.closeDate')  ?></small>
            <p><?= showDateAndTime($opportunityData['close_date'], 1) ?> </p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.amount') ?></small>
            <p><?= showMoney($opportunityData['amount'], $opportunityData['currency']) ?> </p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.probability')  ?></small>
            <p><?= $opportunityData['probability'] ?> </p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.leadSource')  ?></small>
            <p><?= lang('Crm.leadsSourcesList')[$opportunityData['lead_source'] ] ?></p>
          </div>

          
          <div class="border-bottom border-light col-sm-12 col-md-8 col-lg-8 col-xl-8">
            <small class="text-muted"><?= lang('Crm.description')  ?></small>
            <p><?= $opportunityData['description'] ?> </p>
          </div>




        </div> <!---- BEIDZAS PAMATINFO  -->


        <?= view_cell('\App\Controllers\crm\Viewcells::getActionHistory', ['id' => $opportunityData['id'], 'type' => 8]) ?>


      </div> <!---- BEIDZAS LIELĀ col-sm-9  -->



      <div class="col-sm-12 col-md-3 col-lg-3"> <!---- SĀKAS SĀNU col-sm-3  -->

        <div class="mt-3"><!---- SĀKAS PIEŠĶIRTAIS -->
          <div class="border-bottom border-light">
            <small class="text-muted"><?= lang('Crm.assignedUser') ?></small>

            <?php

            if (!empty($opportunityData['user_id'])) {

              echo '<p><a href="' . base_url('crm/user') . '/' . $opportunityData['user_id'] . '">' . $opportunityData['user_full_name'] .'</a></p>
              ';
            } else {
              echo '<p>' . lang('Crm.noAssignedUser') . '</p>';
            }

            ?>
          </div>
        </div> <!---- BEIDZAS PIEŠĶIRTAIS -->


        <div> <!---- DATUMI -->
          <div class="border-bottom border-light mb-3">


            <small class="text-secondary"><?= lang('Crm.addDate') ?></small>
            <p><?= showDateAndTime($opportunityData['creation_date'], 2) ?></p>

            <small class="text-secondary"><?= lang('Crm.editDate') ?></small>
            <p><?= showDateAndTime($opportunityData['edit_date'], 2) ?></p>

          </div>
        </div> <!---- BEIDZAS DATUMI -->


        <?= view_cell('\App\Controllers\crm\Viewcells::opportunityActivitiesList', ['opportunityId' => $opportunityData['id']]) ?>

        <?= view_cell('\App\Controllers\crm\Viewcells::opportunityHistoryList', ['opportunityId' => $opportunityData['id']]) ?>

        <?= view_cell('\App\Controllers\crm\Viewcells::opportunityTasksList', ['opportunityId' => $opportunityData['id']]) ?>


      </div> <!---- BEIDZAS SĀNU col-sm-3  -->


    </div>


  </div>