</head>

<body class="bg-light text-dark">

  <?= view('default/crm/navbar.php') ?>

  <div class="container col-11 text-dark bg-white mt-3 border pl-0 pr-0">
    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item "><a href="<?= base_url('crm/leads/') ?>"><?= lang('Crm.leads') ?></a></li>
      <li class="breadcrumb-item active"><?= $lead_title ?></li>
    </ul>


    <div class="row pl-3 pr-3 pb-3">

      <div class="col-sm-12">

        <?= view('default/crm/crm_message_box.php') ?>

        <div class="btn-group float-right pt-0 pb-0 ">
          <a type="button" href="<?= base_url('crm/lead/edit') ?>/<?= $leadData['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-pen" style="font-size:12px"></i> <?= lang('Crm.edit') ?> </a>
          <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
            <span class="caret"></span>
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <?php if ($leadData['active'] == 1) : ?>
              <a class="dropdown-item delete-link " data-confirm-message="<?= lang('Crm.delete') ?>?" href="<?= base_url('crm/delete-record/') ?><?= $leadData['id'] . '/3' ?>"><i class="fas fa-trash" style="font-size:12px"></i> <?= lang('Crm.delete') ?> </a>
            <?php else : ?>
              <a class="dropdown-item delete-link" data-confirm-message="<?= lang('Crm.undelete') ?>?" href="<?= base_url('crm/delete-record/') ?><?= $leadData['id'] . '/3' ?>"><i class="fas fa-check" style="font-size:12px"></i> <?= lang('Crm.undelete') ?> </a>
            <?php endif; ?>
            <hr>
            <a class="dropdown-item export-link" href="<?= base_url('crm/companies/new') ?>?leadid=<?= $leadData['id'] ?>"><i class="fas fa-plus-square" style="font-size:12px"></i> <?= lang('Crm.exportAsCompany') ?> </a>
            <a class="dropdown-item export-link" href="<?= base_url('crm/persons/new') ?>?leadid=<?= $leadData['id'] ?>"><i class="far fa-plus-square" style="font-size:12px"></i> <?= lang('Crm.exportAsPerson') ?> </a>
          </div>
        </div>



      </div>



      <div class="col-sm-9">

        <div class="row pb-3"> <!----  PAMATINFO  -->

          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class=" text-muted border-bottom border-light"><?= lang('Crm.name') ?></small>
            <p class=""><?= $leadData['name'] ? $leadData['name'] : lang('Crm.none') ?></p>
          </div>

          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class=" text-muted border-bottom border-light"><?= lang('Crm.surname') ?></small>
            <p class=""><?= $leadData['surname'] ? $leadData['surname'] : lang('Crm.none') ?></p>
          </div>

          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.company') ?></small>
            <p><?= $leadData['account'] ? $leadData['account'] : lang('Crm.none') ?></p>
          </div>

          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.phone') ?></small>
            <p><a href="tel:<?= $leadData['phone'] ?>"><?= $leadData['phone'] ? $leadData['phone'] : '' ?></a></p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.address') ?></small>
            <p><a title="<?= lang('Crm.searchGoogleMaps') ?>" target="_blank" href="<?= $addresses['addressGoogleMapsUrl'] ?>"><?= $addresses['addressLine'] ? $addresses['addressLine'] : '' ?></a></p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.position') ?></small>
            <p><?= $leadData['position'] ? $leadData['position'] : lang('Crm.none') ?> </p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.email') ?></small>
            <p><a href="mailto:<?= $leadData['email'] ?>"><?= $leadData['email'] ?></a></p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.website') ?></small>
            <p><a target="_blank" href="<?= $leadData['website'] ?>"><?= $leadData['website'] ?></a></p>
          </div>


          <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.socialNetwork') ?></small>
            <?php if (!empty($leadData['social_network'])) : ?>
              <p><a href="<?= $leadData['social_network'] ?>" target="_blank"><?= lang('Crm.socialNetwork') ?></a></p>
            <?php endif; ?>
          </div>


          <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.description') ?></small>
            <p><?= $leadData['description'] ? $leadData['description'] : lang('Crm.none') ?></p>
          </div>

          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.status') ?></small>
            <p><?= lang('Crm.leadStatusList')[$leadData['status']] ?></p>
          </div>

          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.source') ?></small>
            <p><?= lang('Crm.leadsSourcesList')[$leadData['source']] ?></p>
          </div>


        </div> <!---- BEIDZAS PAMATINFO  -->


        <?= view_cell('\App\Controllers\crm\Viewcells::getActionHistory', ['id' => $leadData['id'], 'type' => 3]) ?>


      </div> <!---- BEIDZAS LIELĀ col-sm-9  -->



      <div class="col-sm-3"> <!---- SĀKAS SĀNU col-sm-3  -->

        <div class="mt-3"><!---- SĀKAS PIEŠĶIRTAIS -->
          <div class="border-bottom border-light">
            <small class="text-muted"><?= lang('Crm.assignedUser') ?></small>

            <?php

            if (!empty($leadData['user_id'])) {

              echo '<p><a href="' . base_url('crm/user') . '/' . $leadData['user_id'] . '">' . $leadData['user_name'] . ' ' . $leadData['user_surname'] . '</a></p>
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
            <p><?= showDateAndTime($leadData['creation_date'], 2) ?></p>

            <small class="text-secondary"><?= lang('Crm.editDate') ?></small>
            <p><?= showDateAndTime($leadData['edit_date'], 2) ?></p>

          </div>
        </div> <!---- BEIDZAS DATUMI -->

        <?= view_cell('\App\Controllers\crm\Viewcells::leadActivitiesList', ['leadId' => $leadData['id']]) ?>

        <?= view_cell('\App\Controllers\crm\Viewcells::leadHistoryList', ['leadId' => $leadData['id']]) ?>

        <?= view_cell('\App\Controllers\crm\Viewcells::leadTasksList', ['leadId' => $leadData['id']]) ?>


      </div> <!---- BEIDZAS SĀNU col-sm-3  -->


    </div>




  </div>