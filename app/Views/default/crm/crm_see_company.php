</head>

<body class="bg-light text-dark">

  <?= view('default/crm/navbar.php') ?>

  <div class="container col-11 text-dark bg-white mt-3 border pl-0 pr-0">
    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item "><a href="<?= base_url('crm/companies/') ?>"><?= lang('Crm.companies') ?></a></li>
      <li class="breadcrumb-item active"><?= $companyData['title'] ?></li>
    </ul>

    <div class="row pl-3 pr-3 pb-3">

      <div class="col-sm-12">

        <?= view('default/crm/crm_message_box.php') ?>

        <div class="btn-group float-right pt-0 pb-0 ">
          <a type="button" href="<?= base_url('crm/company/edit') ?>/<?= $companyData['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-pen" style="font-size:12px"></i> <?= lang('Crm.edit') ?></a>
          <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
            <span class="caret"></span>
          </button>
          <div class="dropdown-menu  dropdown-menu-right">
            <?php if ($companyData['active'] == 1) : ?>
              <a class="dropdown-item delete-link" data-confirm-message="<?= lang('Crm.delete') ?>?" href="<?= base_url('crm/delete-record/') ?><?= $companyData['id'] . '/1' ?>"><i class="fas fa-trash" style="font-size:12px"></i> <?= lang('Crm.delete') ?> </a>
            <?php else : ?>
              <a class="dropdown-item delete-link" data-confirm-message="<?= lang('Crm.undelete') ?>?" href="<?= base_url('crm/delete-record/') ?><?= $companyData['id'] . '/1' ?>"><i class="fas fa-check" style="font-size:12px"></i> <?= lang('Crm.undelete') ?> </a>
            <?php endif; ?>
          </div>
        </div>

      </div>

      <div class="col-sm-9">

        <div class="row pb-3"> <!----  PAMATINFO  -->

          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.title') ?></small>
            <p class="active-<?= $companyData['active'] ?>"><?= $companyData['title'] ?></p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.phone') ?></small>
            <p><a href="tel:<?= $companyData['phone'] ?>"><?= $companyData['phone'] ?></a></p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.email') ?></small>
            <p><a href="mailto:<?= $companyData['email'] ?>"><?= $companyData['email'] ?></a></p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted text-dark"><?= lang('Crm.address') ?></small>
            <p><a title="<?= lang('Crm.searchGoogleMaps') ?>" target="_blank" href="<?= $addressGoogleMapsUrl ?>"><?= $address ?></a></p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.phoneTwo') ?></small>
            <p><a href="tel:<?= $companyData['second_phone'] ?>"><?= $companyData['second_phone'] ?></a></p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.website') ?></small>
            <p><a target="_blank" href="<?= $companyData['website'] ?>"><?= $companyData['website'] ?></a></p>
          </div>


          <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.description') ?></small>
            <p><?= $companyData['description'] ?></p>
          </div>

          <?php
          if (!empty($companyData['fax'])) :
          ?>

            <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-4">
              <small class="text-muted"><?= lang('Crm.fax') ?></small>
              <p><?= $companyData['fax'] ?></p>
            </div>

          <?php
          endif;
          if (!empty($companyData['reg_nr']) || !empty($companyData['vat_nr'])) :
          ?>

            <div class="pt-2 col-sm-12 col-md-6 col-lg-6 col-xl-4">
              <p>
                <a class="text-body " href="#regData" data-toggle="collapse"><small class="text-muted"><?= lang('Crm.regData') ?></small> <i style='font-size:12px' class='fas fa-angle-down'></i></a>
              </p>

              <div id="regData" class="collapse">

                <div>
                  <small class="text-muted text-secondary"><?= lang('Crm.regNr') ?></small>
                  <p><?= $companyData['reg_nr'] ?></p>
                </div>

                <div>
                  <small class="text-muted text-secondary"><?= lang('Crm.vatNr') ?></small>
                  <p><?= $companyData['vat_nr'] ?></p>
                </div>

              </div>
            </div>


          <?php
          endif;
          if (!empty($companyData['bank_title']) || !empty($companyData['bank_acc_nr'])) :
          ?>

            <div class="pt-2 col-sm-12 col-md-6 col-lg-6 col-xl-4">
              <p>
                <a class="text-body " href="#bankData" data-toggle="collapse"><small class="text-muted"><?= lang('Crm.bankData') ?></small> <i style='font-size:12px' class='fas fa-angle-down'></i></a>
              </p>

              <div id="bankData" class="collapse">

                <div class="">
                  <small class="text-muted text-secondary"><?= lang('Crm.bankTitle') ?></small>
                  <p><?= $companyData['bank_title'] ?></p>
                </div>

                <div class="">
                  <small class="text-muted text-secondary"><?= lang('Crm.bankCode') ?></small>
                  <p><?= $companyData['bank_code'] ?></p>
                </div>

                <div class="">
                  <small class="text-muted text-secondary"><?= lang('Crm.bankAcc') ?></small>
                  <p><?= $companyData['bank_acc_nr'] ?></p>
                </div>

              </div>
            </div>

          <?php endif; ?>

        </div> <!---- BEIDZAS PAMATINFO  -->


        <?= view_cell('\App\Controllers\crm\Viewcells::companyContactsList', ['companyId' => $companyData['id']]) ?>
        <p></p>
        <?= view_cell('\App\Controllers\crm\Viewcells::getActionHistory', ['id' => $companyData['id'], 'type' => 1]) ?>
        <p></p>
        <?= view_cell('\App\Controllers\crm\Viewcells::unitOpportunityList', [ 'parentType' => 1,'parentId' => $companyData['id']]) ?>

      </div> <!---- BEIDZAS LIELĀ col-sm-9  -->


      <div class="col-sm-3"> <!---- SĀKAS SĀNU col-sm-3  -->

        <div><!---- SĀKAS PIEŠĶIRTAIS -->
          <div class="border-bottom border-light mt-2">
            <small class="text-muted"><?= lang('Crm.assignedUser') ?></small>

            <?php

            if (!empty($companyData['user_id'])) 
            {
              echo '<p><a href="' . base_url('crm/user') . '/' . $companyData['user_id'] . '">' . $companyData['user_full_name'] . '</a></p>
              ';
            } 
            else 
            {
              echo '<p>' . lang('Crm.noAssignedUser') . '</p>';
            }

            ?>
          </div>
        </div> <!---- BEIDZAS PIEŠĶIRTAIS -->


        <div> <!---- DATUMI -->
          <div class="border-bottom border-light mb-3">


            <small class="text-secondary"><?= lang('Crm.addDate') ?></small>
            <p><?= showDateAndTime($companyData['creation_date'], 2) ?></p>

            <small class="text-secondary"><?= lang('Crm.editDate') ?></small>
            <p><?= showDateAndTime($companyData['edit_date'], 2) ?></p>

          </div>
        </div> <!---- BEIDZAS DATUMI -->


        <?= view_cell('\App\Controllers\crm\Viewcells::companyActivitiesList', ['companyId' => $companyData['id']]) ?>

        <?= view_cell('\App\Controllers\crm\Viewcells::companyHistoryList', ['companyId' => $companyData['id']]) ?>

        <?= view_cell('\App\Controllers\crm\Viewcells::companyTasksList', ['companyId' => $companyData['id']]) ?>


      </div> <!---- BEIDZAS SĀNU col-sm-3  -->

    </div>

  </div>

