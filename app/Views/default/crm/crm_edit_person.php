</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>


  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">
    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle'); ?></a></li>
      <li class="breadcrumb-item "><a href="<?= base_url('crm/persons/') ?>"><?= lang('Crm.persons'); ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.edit') ?> - <?= $personData['name'] ?> <?= $personData['surname'] ?></li>
    </ul>

    <form action="<?= base_url('crm/persons/save'); ?>" id="addForm" method="post">
      <?= csrf_field() ?>



      <div class="row pl-3 pr-3 pb-3">


        <div class="col-sm-12">

          <button type="submit" id="sbutton" class="btn btn-info btn-sm float-right"><i class='fas fa-save' style='font-size:12px'></i> <?= lang('Crm.save') ?></button>

        </div>


        <div class="col-sm-4 ">


          <div class="form-group">
            <label class="small "><?= lang('Crm.name'); ?>: *</label>
            <input type="text" class="form-control" id="name" value="<?= $personData['name'] ?>" name="name" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.surname'); ?>: </label>
            <input type="text" class="form-control" id="surname" value="<?= $personData['surname'] ?>" autocomplete="off" name="surname">
          </div>


          <div class="form-group">
            <label class="small"><?= lang('Crm.birthdayDate'); ?>: </label>
            <input type="date" id="birthday" name="birthday" class="form-control" value="<?= $personData['birthday'] ?>">
          </div>


          <hr class=" border-muted">

          <div class="form-group">
            <label class="small"><?= lang('Crm.phoneOne'); ?>: </label>
            <input type="text" class="form-control" id="phone" value="<?= $personData['phone'] ?>" name="phone" maxlength="100" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.phoneTwo'); ?>:</label>
            <input type="text" class="form-control" autocomplete="off" id="phone2" value="<?= $personData['second_phone'] ?>" name="phone2" maxlength="100">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.email'); ?>: </label>
            <input type="text" class="form-control" autocomplete="off" id="email" value="<?= $personData['email'] ?>" name="email">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.socialNetwork'); ?>:</label>
            <input type="text" class="form-control" autocomplete="off" id="socialnetwork" value="<?= $personData['social_network'] ?>" name="socialnetwork" maxlength="100">
          </div>

          <div class="form-group ">
            <label class="small"><?= lang('Crm.website'); ?>: </label>
            <input type="text" class="form-control" autocomplete="off" id="web" name="website" value="<?= $personData['website'] ?>">
          </div>


          <hr class=" border-muted">



          <div class="form-group">
            <label class="small"><?= lang('Crm.description'); ?>:</label>
            <textarea class="form-control" rows="5" id="description" name="description"><?= $personData['website'] ?></textarea>
          </div>

        </div>


        <div class="col-sm-4 ">


          <div class="form-group">
            <label class="small"><?= lang('Crm.company') ?>: </label>

            <div class="input-group  mb-0">
              <input id="findCompany" type="text" class="form-control" value="<?= $personData['title'] ?>" autocomplete="off">
              <div class="input-group-append">
                <span onclick="removeCompany()" title="<?= lang('Crm.delete') ?>" class="input-group-text"><i style="font-size:12px" class="fa">&#xf00d;</i></span>
              </div>
            </div>
            <div id="resultCompany"></div>
          </div>


          <input type="hidden" id="companyId" name="companyid" value="<?= $personData['company_id'] ?>">
          <input type="hidden" id="id" name="id" value="<?= $personData['id'] ?>">

          <div class="form-group">
            <label class="small"><?= lang('Crm.position'); ?>: </label>
            <input type="text" class="form-control" id="position" value="<?= $personData['position'] ?>" name="position" maxlength="100" autocomplete="off">
          </div>

          <hr class=" border-muted">

          <div class="form-group">
            <label class="small"><?= lang('Crm.addressLine1') ?>:</label>
            <input type="text" class="form-control" id="address1" value="<?= $personData['address1'] ?>" name="address1" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.addressLine2') ?>:</label>
            <input type="text" class="form-control" id="address2" value="<?= $personData['address2'] ?>" name="address2" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.city') ?>:</label>
            <input type="text" class="form-control" id="city" value="<?= $personData['city'] ?>" name="city" maxlength="100" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.country') ?>:</label>
            <input type="text" class="form-control" id="country" value="<?= $personData['country'] ?>" name="country" maxlength="100">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.postCode') ?>:</label>
            <input type="text" class="form-control" id="postcode" value="<?= $personData['postal_code'] ?>" name="postcode" maxlength="10" autocomplete="off">
          </div>

          <hr class=" border-muted">

          <div class="form-group">
            <label class="small"><?= lang('Crm.bankTitle') ?>:</label>
            <input type="text" class="form-control" id="btitle" value="<?= $personData['bank_title'] ?>" name="btitle" maxlength="150" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.bankCode') ?>:</label>
            <input type="text" class="form-control" id="bcode" value="<?= $personData['bank_code'] ?>" name="bcode" maxlength="20" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.bankAcc') ?>:</label>
            <input type="text" class="form-control" id="bankacc" value="<?= $personData['bank_acc_nr'] ?>" name="bankacc" maxlength="50" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="small"><?= lang('Crm.nin'); ?>:</label>
            <input type="text" class="form-control" id="nin" value="<?= $personData['nin'] ?>" name="nin" maxlength="11" autocomplete="off">
          </div>


        </div>

        <div class="col-sm-4 ">


          <?php if (!empty($personData['user_id'])) : ?>

            <input type="hidden" id="userId" name="userid" value="<?= $personData['user_id'] ?>">

          <?php else : ?>

            <input type="hidden" id="userId" name="userid">

          <?php endif; ?>



          <?php if (userAdmin()):  ?>
            
            <div class="form-group">
              <label class="small"><?= lang('Crm.assignedUser') ?>: </label>

              <div class="input-group  mb-0">
                <input id="findUser" name="userfullname" type="text" class="form-control" value="<?= $personData['user_name'] ?><?= $personData['user_surname'] ?>" autocomplete="off">
                <div class="input-group-append">
                  <span onclick="removeAssignedUser()" title="<?= lang('Crm.delete') ?>" class="input-group-text"><i style="font-size:12px" class="fa">&#xf00d;</i></span>
                </div>
              </div>
              <div id="resultUser"></div>
            </div>


          <?php else : ?>


            <div class="form-group">
              <label class="small"><?= lang('Crm.assignedUser'); ?>:</label>
              <input type="text" name="userfullname" class="form-control" id="findUser" value="<?= $personData['user_name'] ?> <?= $personData['user_surname'] ?>" readonly>
            </div>


          <?php endif; ?>


          <hr class=" border-muted">


    </form>

  </div>


  </div>
  </div>



  <script>
    var findCompanyUrl = "<?= base_url('ajax/search-connected-company') ?>";
    var findUserUrl = "<?= base_url('ajax/search-assigned-user') ?>";
  </script>

