</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">
    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item "><a href="<?= base_url('crm/companies/') ?>"><?= lang('Crm.companies') ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.edit') ?> - <?= $companyData['title'] ?></li>
    </ul>

    <form action="<?= base_url('crm/companies/save'); ?>" id="addForm" method="post">
      <?= csrf_field() ?>


      <div class="row pl-3 pr-3 pb-3">


        <div class="col-sm-12">

          <button type="submit" id="sbutton" class="btn btn-info btn-sm float-right"><i class='fas fa-save' style='font-size:12px'></i> <?= lang('Crm.save') ?></button>

        </div>


        <div class="col-sm-4 ">

          <div class="form-group">
            <label class="small"><?= lang('Crm.companyTitle'); ?>: *</label>
            <input type="text" class="form-control" id="title" value="<?= $companyData['title'] ?>" name="title" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.phoneOne'); ?>: </label>
            <input type="text" class="form-control" id="phone" value="<?= $companyData['phone'] ?>" name="phone" maxlength="100" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.phoneTwo'); ?>:</label>
            <input type="text" class="form-control" id="phone2" value="<?= $companyData['second_phone'] ?>" name="phone2" maxlength="100" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.email'); ?>: </label>
            <input type="text" class="form-control" id="email" value="<?= $companyData['email'] ?>" name="email" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.fax'); ?>:</label>
            <input type="text" class="form-control" id="fax" value="<?= $companyData['fax'] ?>" name="fax" maxlength="100" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.website'); ?>: </label>
            <input type="text" class="form-control" id="web" value="<?= $companyData['website'] ?>" name="website" autocomplete="off">
          </div>

          <hr class=" border-muted">

          <div class="form-group">
            <label class="small"><?= lang('Crm.regNr'); ?>:</label>
            <input type="text" class="form-control" id="rnumber" value="<?= $companyData['reg_nr'] ?>" name="rnumber" maxlength="11" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.vatNr'); ?>:</label>
            <input type="text" class="form-control" id="vnumber" value="<?= $companyData['vat_nr'] ?>" name="vnumber" maxlength="13" autocomplete="off">
          </div>

          <hr class=" border-muted">

          <div class="form-group">
            <label class="small"><?= lang('Crm.description'); ?>:</label>
            <textarea class="form-control" rows="5" id="description" name="description"><?= $companyData['description'] ?></textarea>
          </div>

        </div>


        <div class="col-sm-4 ">

          <div class="form-group">
            <label class="small"><?= lang('Crm.addressLine1') ?>:</label>
            <input type="text" class="form-control" id="address1" value="<?= $companyData['address1'] ?>" name="address1" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.addressLine2') ?>:</label>
            <input type="text" class="form-control" id="address2" value="<?= $companyData['address2'] ?>" name="address2" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.city') ?>:</label>
            <input type="text" class="form-control" id="city" value="<?= $companyData['city'] ?>" name="city" maxlength="100" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.country') ?>:</label>
            <input type="text" class="form-control" id="country" value="<?= $companyData['country'] ?>" name="country" maxlength="100">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.postCode') ?>:</label>
            <input type="text" class="form-control" id="postcode" value="<?= $companyData['postal_code'] ?>" name="postcode" maxlength="10" autocomplete="off">
          </div>

          <hr class=" border-muted">

          <div class="form-group">
            <label class="small"><?= lang('Crm.bankTitle') ?>:</label>
            <input type="text" class="form-control" id="btitle" value="<?= $companyData['bank_title'] ?>" name="btitle" maxlength="150" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.bankCode'); ?>:</label>
            <input type="text" class="form-control" id="bcode" value="<?= $companyData['bank_code'] ?>" name="bcode" maxlength="20" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.bankAcc'); ?>:</label>
            <input type="text" class="form-control" id="bankacc" value="<?= $companyData['bank_acc_nr'] ?>" name="bankacc" maxlength="50" autocomplete="off">
          </div>


        </div>

        <div class="col-sm-4 ">

          <input type="hidden" id="id" name="id" value="<?= $companyData['id'] ?>">



          <?php if (session()->get('userRights') < 1):  ?>


            <input type="hidden" id="userId" name="userid" value="<?= $companyData['user_id'] ?>">

            <div class="form-group">
              <label class="small"><?= lang('Crm.assignedUser') ?>: </label>

              <div class="input-group  mb-0">
                <input id="findUser" type="text" class="form-control" name="userfullname" value="<?php if (!empty($companyData['user_id'])) {echo $companyData['user_full_name'];} ?>" autocomplete="off">
                <div class="input-group-append">
                  <span onclick="removeAssignedUser()" title="<?= lang('Crm.delete') ?>" class="input-group-text"><i style="font-size:12px" class="fa">&#xf00d;</i></span>
                </div>
              </div>
              <div id="resultUser"></div>
            </div>


          <?php else: ?>


            <input type="hidden" id="userId" name="userid" value="<?= $companyData['user_id'] ?>">


            <div class="form-group">
              <label class="small"><?= lang('Crm.assignedUser'); ?>:</label>
              <input type="text" class="form-control" id="findUser" name="userfullname" value="<?php if (!empty($companyData['user_id'])) {echo $companyData['user_full_name'];} ?>" readonly>
            </div>


          <?php endif; ?>


          <hr class=" border-muted">




    </form>

  </div>


  </div>
  </div>



  <script>
    var findUserUrl = "<?= base_url('ajax/search-assigned-user')?>";


  </script>