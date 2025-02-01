</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">
    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item "><a href="<?= base_url('crm/companies/') ?>"><?= lang('Crm.companies') ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.createNew') ?></li>
    </ul>

    <form action="<?= base_url('crm/companies/save') ?>" id="addForm" method="post">
      <?= csrf_field() ?>

      <input type="hidden" id="leadId" name="leadid" value="<?= $leadData['id'] ?>">

      <div class="row pl-3 pr-3 pb-3">

        <div class="col-sm-12">
          <button type="submit" id="sbutton" class="btn btn-info btn-sm float-right"><i class='fas fa-save' style='font-size:12px'></i> <?= lang('Install.create') ?> </button>
        </div>

        <div class="col-sm-4 ">

          <div class="form-group">
            <label for="title" class="small"><?= lang('Crm.companyTitle'); ?>: *</label>
            <input type="text" class="form-control" id="title" placeholder="<?= lang('Crm.companyTitle') ?>" value="<?= $leadData['account'] ?>" name="title" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="phone" class="small"><?= lang('Crm.phoneOne'); ?>: </label>
            <input type="text" class="form-control" id="phone" placeholder="<?= lang('Crm.phoneOne') ?>" value="<?= $leadData['phone'] ?>" name="phone" maxlength="100" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="phone2" class="small"><?= lang('Crm.phoneTwo'); ?>:</label>
            <input type="text" class="form-control" id="phone2" placeholder="<?= lang('Crm.phoneTwo') ?>" name="phone2" maxlength="100" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="email" class="small"><?= lang('Crm.email'); ?>: </label>
            <input type="text" class="form-control" id="email" placeholder="<?= lang('Crm.email') ?>" value="<?= $leadData['email'] ?>" name="email" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="fax" class="small"><?= lang('Crm.fax'); ?>:</label>
            <input type="text" class="form-control" id="fax" placeholder="<?= lang('Crm.fax') ?>" name="fax" maxlength="100" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="web" class="small"><?= lang('Crm.website'); ?>: </label>
            <input type="text" class="form-control" id="web" placeholder="<?= lang('Crm.website') ?>" value="<?= $leadData['website'] ?>" name="website" autocomplete="off">
          </div>

          <hr class=" border-muted">

          <div class="form-group">
            <label for="rnumber" class="small"><?= lang('Crm.regNr'); ?>:</label>
            <input type="text" class="form-control" id="rnumber" placeholder="<?= lang('Crm.regNr') ?>" name="rnumber" maxlength="11" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="vnumber" class="small"><?= lang('Crm.vatNr'); ?>:</label>
            <input type="text" class="form-control" id="vnumber" placeholder="<?= lang('Crm.vatNr') ?>" name="vnumber" maxlength="13" autocomplete="off">
          </div>

          <hr class=" border-muted">

          <div class="form-group">
            <label for="description" class="small"><?= lang('Crm.description'); ?>:</label>
            <textarea class="form-control" rows="5" id="description" name="description"><?= $leadData['description'] ?></textarea>
          </div>

        </div>

        <div class="col-sm-4 ">

          <div class="form-group">
            <label for="address1" class="small"><?= lang('Crm.addressLine1') ?>:</label>
            <input type="text" class="form-control" id="address1" placeholder="<?= lang('Crm.addressLine1') ?>" value="<?= $leadData['address1'] ?>" name="address1" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="address2" class="small"><?= lang('Crm.addressLine2') ?>:</label>
            <input type="text" class="form-control" id="address2" placeholder="<?= lang('Crm.addressLine2') ?>" value="<?= $leadData['address2'] ?>" name="address2" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="city" class="small"><?= lang('Crm.city') ?>:</label>
            <input type="text" class="form-control" id="city" placeholder="<?= lang('Crm.city') ?>" value="<?= $leadData['city'] ?>" name="city" maxlength="100" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="country" class="small"><?= lang('Crm.country') ?>:</label>
            <input type="text" class="form-control" id="country" placeholder="<?= lang('Crm.country') ?>" value="<?= $leadData['country'] ?>" name="country" maxlength="100">
          </div>

          <div class="form-group">
            <label for="postcode" class="small"><?= lang('Crm.postCode') ?>:</label>
            <input type="text" class="form-control" id="postcode" placeholder="<?= lang('Crm.postCode') ?>" value="<?= $leadData['postal_code'] ?>" name="postcode" maxlength="10" autocomplete="off">
          </div>

          <hr class=" border-muted">

          <div class="form-group">
            <label for="btitle" class="small"><?= lang('Crm.bankTitle') ?>:</label>
            <input type="text" class="form-control" id="btitle" placeholder="<?= lang('Crm.bankTitle') ?>" name="btitle" maxlength="150" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="bcode" class="small"><?= lang('Crm.bankCode'); ?>:</label>
            <input type="text" class="form-control" id="bcode" placeholder="<?= lang('Crm.bankCode') ?>" name="bcode" maxlength="20" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="bankacc" class="small"><?= lang('Crm.bankAcc'); ?>:</label>
            <input type="text" class="form-control" id="bankacc" placeholder="<?= lang('Crm.bankAcc') ?>" name="bankacc" maxlength="50" autocomplete="off">
          </div>

        </div>

        <div class="col-sm-4 ">


          <?php if (userAdmin()):  ?>

            <input type="hidden" id="userId" name="userid" value="<?= session()->get('userId') ?>">

            <div class="form-group">
              <label class="small"><?= lang('Crm.assignedUser') ?>: </label>

              <div class="input-group  mb-0">
                <input id="findUser" type="text" name="userfullname" class="form-control" placeholder="<?= lang('Crm.startWriteName') ?>" autocomplete="off" value="<?= session()->get('userName') ?> <?= session()->get('userSurname') ?>">
                <div class="input-group-append">
                  <span onclick="removeAssignedUser()" title="<?= lang('Crm.delete') ?>" class="input-group-text"><i style="font-size:12px" class="fa">&#xf00d;</i></span>
                </div>
              </div>
              <div id="resultUser"></div>
            </div>

          <?php else : ?>

            <input type="hidden" id="userId" name="userid" value="<?= session()->get('userId') ?>">

            <div class="form-group">
              <label class="small"><?= lang('Crm.assignedUser'); ?>:</label>
              <input type="text" class="form-control" id="findUser" name="userfullname" value="<?= session()->get('userName') ?> <?= session()->get('userSurname') ?>" readonly>
            </div>

          <?php endif; ?>

          <hr class=" border-muted">

        </div>
      </div>
    </form>

  </div>


  <script>
    var findUserUrl = "<?= base_url('ajax/search-assigned-user') ?>";
  </script>
  <script src="<?= base_url('assets/js/') ?>crm.js"></script>