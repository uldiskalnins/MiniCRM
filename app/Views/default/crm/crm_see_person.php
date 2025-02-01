</head>

<body class="bg-light text-dark">

  <?= view('default/crm/navbar.php') ?>

  <div class="container col-11 text-dark bg-white mt-3 border pl-0 pr-0">
    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item "><a href="<?= base_url('crm/persons/') ?>"><?= lang('Crm.persons') ?></a></li>
      <li class="breadcrumb-item active"><?= $personData['name'] ?> <?= $personData['surname'] ?></li>
    </ul>


    <div class="row pl-3 pr-3 pb-3">

      <div class="col-sm-12">

        <?= view('default/crm/crm_message_box.php') ?>

        <div class="btn-group float-right pt-0 pb-0 ">
          <a type="button" href="<?= base_url('crm/person/edit') ?>/<?= $personData['id']?>" class="btn btn-info btn-sm"><i class="fas fa-pen" style="font-size:12px"></i> <?= lang('Crm.edit') ?> </a>
          <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
            <span class="caret"></span>
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <?php if ($personData['active'] == 1) : ?>
              <a class="dropdown-item delete-link" data-confirm-message="<?= lang('Crm.delete')?>?" href="<?= base_url('crm/delete-record/') ?><?= $personData['id'] . '/2' ?>" ><i class="fas fa-trash" style="font-size:12px"></i> <?= lang('Crm.delete') ?> </a>
            <?php else : ?>
              <a class="dropdown-item delete-link" data-confirm-message="<?= lang('Crm.undelete')?>?" href="<?= base_url('crm/delete-record/') ?><?= $personData['id'] . '/2' ?>" ><i class="fas fa-check" style="font-size:12px"></i> <?= lang('Crm.undelete') ?> </a>
            <?php endif; ?>
          </div>
        </div>

      </div>

      <div class="col-sm-9">

        <div class="row pb-3"> <!----  PAMATINFO  -->

          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class=" text-muted border-bottom border-light"><?= lang('Crm.name') ?></small>
            <p class=""><?= $personData['name'] ?> <?= $personData['surname'] ?></p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.phone') ?></small>
            <p><a href="tel:<?= $personData['phone'] ?>"><?= $personData['phone'] ?></a></p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.company') ?></small>
            <p><a href="<?= base_url('crm/company') ?>/<?= $personData['company_id'] ?>"><?= $personData['title'] ?></a>
              <small class="text-muted"></small>
            </p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.address') ?></small>
            <p><a title="<?= lang('Crm.searchGoogleMaps') ?>" target="_blank" href="<?= $addresses['addressGoogleMapsUrl'] ?>"><?= $addresses['addressLine'] ?></a></p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.phoneTwo') ?></small>
            <p><a href="tel:<?= $personData['second_phone'] ?>"><?= $personData['second_phone'] ?></a></p>
          </div>



          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.position') ?></small>
            <p><?= $personData['position'] ?> </p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.birthdayDate') ?></small>
            <p><?= $personData['birthday'] != '0000-00-00' ? showDateAndTime($personData['birthday'], 1): '' ?></p> 
          </div>

          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.email') ?></small>
            <p><a href="mailto:<?= $personData['email'] ?>"><?= $personData['email'] ?></a></p>
          </div>


          <div class="border-bottom border-light col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.website') ?></small>
            <p><a target="_blank" href="<?= $personData['website'] ?>"><?= $personData['website'] ?></a></p>
          </div>


          <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.description') ?></small>
            <p><?= $personData['description'] ?></p>
          </div>


          <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <small class="text-muted"><?= lang('Crm.socialNetwork') ?></small>
            <?php if (!empty($personData['social_network'])) : ?>
              <p><a href="<?= $personData['social_network'] ?>" target="_blank"><?= lang('Crm.socialNetworkUrl') ?></a></p>
            <?php endif; ?>

          </div>



          <?php
          if (!empty($personData['reg_nr']) || !empty($personData['vat_nr'])) :
          ?>

            <div class="pt-2 col-sm-12 col-md-6 col-lg-6 col-xl-4">
              <p>
                <a class="text-body " href="#regData" data-toggle="collapse"><small class="text-muted"><?= lang('Crm.regData') ?></small> <i style='font-size:12px' class='fas fa-angle-down'></i></a>
              </p>

              <div id="regData" class="collapse">

                <div>
                  <small class="text-secondary"><?= lang('Crm.regNr') ?></small>
                  <p><?= $personData['reg_nr'] ?></p>
                </div>

                <div>
                  <small class="text-secondary"><?= lang('Crm.vatNr') ?></small>
                  <p><?= $personData['reg_nr'] ?></p>
                </div>

              </div>
            </div>


          <?php

          endif;
          if (!empty($personData['bank_title']) || !empty($personData['bank_acc_nr'])) :

          ?>

            <div class="pt-2 col-sm-12 col-md-6 col-lg-6 col-xl-4">
              <p>
                <a class="text-body " href="#bankData" data-toggle="collapse"><small class="text-muted"><?= lang('Crm.bankData') ?></small> <i style='font-size:12px' class='fas fa-angle-down'></i></a>
              </p>

              <div id="bankData" class="collapse">

                <div>
                  <small class="text-secondary"><?= lang('Crm.bankTitle') ?></small>
                  <p><?= $personData['bank_title'] ?></p>
                </div>

                <div>
                  <small class="text-secondary"><?= lang('Crm.bankCode') ?></small>
                  <p><?= $personData['bank_code'] ?></p>
                </div>

                <div>
                  <small class="text-secondary"><?= lang('Crm.bankAcc') ?></small>
                  <p><?= $personData['bank_acc_nr'] ?></p>
                </div>

                <div>
                  <small class="text-secondary"><?= lang('Crm.nin') ?></small>
                  <p><?= $personData['nin'] ?></p>
                </div>

              </div>
            </div>

          <?php endif; ?>


        </div> <!---- BEIDZAS PAMATINFO  -->

        <?= view_cell('\App\Controllers\crm\Viewcells::getActionHistory', ['id' => $personData['id'], 'type' => 2]) ?>
        <p></p>
        <?= view_cell('\App\Controllers\crm\Viewcells::unitOpportunityList', [ 'parentType' => 2,'parentId' => $personData['id']]) ?>



      </div> <!---- BEIDZAS LIELĀ col-sm-9  -->

      <div class="col-sm-3"> <!---- SĀKAS SĀNU col-sm-3  -->

        <div class="mt-3"><!---- SĀKAS PIEŠĶIRTAIS -->
          <div class="border-bottom border-light">
            <small class="text-muted"><?= lang('Crm.assignedUser') ?></small>

            <?php

            if (!empty($personData['user_id'])) {

              echo '<p><a href="' . base_url('crm/user') . '/' . $personData['user_id'] . '">' . $personData['user_name'] . ' ' . $personData['user_surname'] . '</a></p>
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
            <p><?= showDateAndTime($personData['creation_date'], 2) ?></p>

            <small class="text-secondary"><?= lang('Crm.editDate') ?></small>
            <p><?= showDateAndTime($personData['edit_date'], 2) ?></p>

          </div>
        </div> <!---- BEIDZAS DATUMI -->


        <?= view_cell('\App\Controllers\crm\Viewcells::personActivitiesList', ['personId' => $personData['id']]) ?>

        <?= view_cell('\App\Controllers\crm\Viewcells::personHistoryList', ['personId' => $personData['id']]) ?>

        <?= view_cell('\App\Controllers\crm\Viewcells::personTasksList', ['personId' => $personData['id']]) ?>


      </div> <!---- BEIDZAS SĀNU col-sm-3  -->

    </div>

    <div class="row">
      <div class="col-*-*"></div>
      <div class="col-*-*"></div>
      <div class="col-*-*"></div>
    </div>

  </div>

  <script>var confirmMessage =  "<?= lang('Crm.execute') ?>?";</script>
 
