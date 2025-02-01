</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>



  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">
    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle'); ?></a></li>
      <li class="breadcrumb-item "><a href="<?= base_url('crm/leads/') ?>"><?= lang('Crm.leads'); ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.edit') ?> - <?= $lead_title ?></li>
    </ul>

    <form action="<?= base_url('crm/leads/save'); ?>" id="addForm" method="post">
      <?= csrf_field() ?>



      <div class="row pl-3 pr-3 pb-3">

        <div class="col-sm-12">

          <button type="submit" id="sbutton" class="btn btn-info btn-sm float-right"><i class='fas fa-save' style='font-size:12px'></i> <?= lang('Crm.save') ?></button>

        </div>

        <div class="col-sm-4 ">

          <div class="form-group">
            <label for="name" class="small "><?= lang('Crm.name'); ?>: * </label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $leadData['name'] ?>" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="position" class="small "><?= lang('Crm.position'); ?>: </label>
            <input type="text" class="form-control" id="position" value="<?= $leadData['position'] ?>" name="position" maxlength="100" autocomplete="off">
          </div>

          <hr class=" border-muted">

          <div class="form-group">
            <label for="phone" class="small "><?= lang('Crm.phoneOne') ?>: </label>
            <input type="text" class="form-control" id="phone" name="phone" maxlength="100" autocomplete="off" value="<?= $leadData['phone'] ?>">
          </div>


          <div class="form-group">
            <label for="email" class="small "><?= lang('Crm.email'); ?>: </label>
            <input type="text" class="form-control" id="email" name="email" value="<?= $leadData['email'] ?>" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="social" class="small "><?= lang('Crm.socialNetwork'); ?>:</label>
            <input type="text" class="form-control" id="social" value="<?= $leadData['social_network'] ?>" name="social" maxlength="1000" autocomplete="off">
          </div>

          <div class="form-group ">
            <label for="web" class="small "><?= lang('Crm.website'); ?>: </label>
            <input type="text" class="form-control" id="web" value="<?= $leadData['website'] ?>" name="website" maxlength="1000" autocomplete="off">
          </div>


          <hr class=" border-muted">

          <div class="form-group">
            <label for="description" class="small "><?= lang('Crm.description'); ?>:</label>
            <textarea class="form-control" rows="5" id="description" name="description"> <?= $leadData['description'] ?></textarea>
          </div>

        </div>


        <div class="col-sm-4 ">



          <div class="form-group">
            <label for="surname" class="small "><?= lang('Crm.surname') ?>: </label>
            <input type="text" class="form-control" id="surname" name="surname" value="<?= $leadData['surname'] ?>" autocomplete="off">
          </div>


          <div class="form-group">
            <label for="account" class="small "><?= lang('Crm.company') ?>: </label>
            <input type="text" class="form-control" id="account" value="<?= $leadData['account'] ?>" name="account" autocomplete="off">
          </div>


          <hr class=" border-muted">


          <div class="form-group">
            <label for="status" class="small "><?= lang('Crm.status') ?>:</label>
            <select id="status" class="form-control" name="status">

              <?php
              $statusList = lang('Crm.leadStatusList');

              if (is_array($statusList)) {
                foreach ($statusList as $key => $val) {
                  echo ' <option value="' . $key . '"' . ($leadData['status'] == $key ? " selected" : '') . '>' . $val . '</option>'; //."\n"
                }
              }
              ?>

            </select>
          </div>

          <div class="form-group">
            <label for="source" class="small "><?= lang('Crm.source') ?>:</label>
            <select id="source" class="form-control" name="source">

              <?php
              $sourcesList = lang('Crm.leadsSourcesList');

              if (is_array($sourcesList)) {
                foreach ($sourcesList as $key => $val) {
                  echo ' <option value="' . $key . '"' . ($leadData['source'] == $key ? " selected" : '') . '>' . $val . '</option>'; //."\n"
                }
              }
              ?>

            </select>
          </div>
          <hr class=" border-muted">

          <div class="form-group">
            <label for="address1" class="small "><?= lang('Crm.addressLine1'); ?>:</label>
            <input type="text" class="form-control" id="address1" value="<?= $leadData['address1'] ?>" name="address1" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="address2" class="small "><?= lang('Crm.addressLine2'); ?>:</label>
            <input type="text" class="form-control" id="address2" value="<?= $leadData['address2'] ?>" name="address2" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="city" class="small "><?= lang('Crm.city'); ?>:</label>
            <input type="text" class="form-control" id="city" value="<?= $leadData['city'] ?>" name="city" maxlength="100" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="country" class="small "><?= lang('Crm.country'); ?>:</label>
            <input type="text" class="form-control" id="country" value="<?= $leadData['country'] ?>" name="country" maxlength="100">
          </div>

          <div class="form-group">
            <label for="postcode" class="small "><?= lang('Crm.postCode'); ?>:</label>
            <input type="text" class="form-control" id="postcode" value="<?= $leadData['postal_code'] ?>" name="postcode" maxlength="10" autocomplete="off">
          </div>


        </div>

        <div class="col-sm-4 ">


          <input type="hidden" id="id" name="id" value="<?= $leadData['id'] ?>">

          <?php if (session()->get('userRights') < 1):  ?>


            <input type="hidden" id="userId" name="userid" value="<?= $leadData['user_id'] ?>">

            <div class="form-group">
              <label class="small"><?= lang('Crm.assignedUser') ?>: </label>

              <div class="input-group  mb-0">
                <input id="findUser" type="text" class="form-control" name="userfullname" value="<?php if (!empty($leadData['user_id'])) {
                                                                                                    echo $leadData['user_full_name'];
                                                                                                  } ?>" autocomplete="off">
                <div class="input-group-append">
                  <span onclick="removeAssignedUser()" title="<?= lang('Crm.delete') ?>" class="input-group-text"><i style="font-size:12px" class="fa">&#xf00d;</i></span>
                </div>
              </div>
              <div id="resultUser"></div>
            </div>


          <?php else: ?>


            <input type="hidden" id="userId" name="userid" value="<?= $leadData['user_id'] ?>">


            <div class="form-group">
              <label class="small"><?= lang('Crm.assignedUser'); ?>:</label>
              <input type="text" class="form-control" id="findUser" name="userfullname" value="<?php if (!empty($leadData['user_id'])) {echo $leadData['user_full_name'];} ?>" readonly>
            </div>


          <?php endif; ?>

          <hr class=" border-muted">


    </form>

  </div>


  </div>
  </div>



  <script>
    var findUserUrl = "<?= base_url('ajax/search-assigned-user') ?>";
  </script>