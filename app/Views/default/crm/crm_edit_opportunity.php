</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">


    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle'); ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.editOpportunity') ?> - <?= $opportunityData['title'] ?></li>
    </ul>

    <form action="<?= base_url('crm/opportunities/save/'); ?>" id="addForm" method="post">

      <?= view('default/crm/crm_message_box.php') ?>

      <div class="row pl-3 pr-3 pb-3 ">



        <?= csrf_field() ?>

        <input type="hidden" id="id" name="id" value="<?= $opportunityData['id'] ?>">

        <div class="col-sm-12">

          <button type="submit" id="sbutton" class="btn btn-info btn-sm float-right"><i class='fas fa-save' style='font-size:12px'></i> <?= lang('crm.save') ?></button>

        </div>


        <div class="col-sm-8 row">

          <div class="col-sm-6 ">


            <div class="form-group">
              <label for="title" class="small"><?= lang('Crm.title') ?> *</label>
              <input type="text" class="form-control" name="title" id="title" value="<?= $opportunityData['title']  ?>" required>
            </div>

            <div class="form-group">
              <label for="source" class="small"><?= lang('Crm.leadSource') ?> </label>
              <select class="form-control" id="source" name="source">


                <?php
                $sourcesList = lang('Crm.leadsSourcesList'); // PHP Intelephense mieram

                if (is_array($sourcesList)) {
                  foreach ($sourcesList as $key => $val) {
                    echo ' <option value="' . $key . '"' . ($opportunityData['lead_source'] == $key ? " selected" : '') . '>' . $val . '</option>'; //."\n"
                  }
                }
                ?>

              </select>
            </div>


            <div class="form-group">
              <label for="closeDate" class="small"><?= lang('Crm.closeDate') ?> *</label>
              <input class="form-control" id="closeDate" type="date" name="closedate" value="<?= showDateAndTime($opportunityData['close_date'], 3)  ?>" autocomplete="off" required>
            </div>

          </div>

          <div class="col-sm-6 ">

            <div class="form-group">
              <label for="stage" class="small"><?= lang('Crm.stage') ?></label>
              <select class="form-control" id="stage" name="stage">

                <?php

                $stageList = lang('Crm.opportunityStageList');

                if (is_array($stageList)) {
                  foreach ($stageList as $key => $val) {
                    echo ' <option value="' . $key . '"' . ($opportunityData['stage'] == $key ? " selected" : '') . '>' . $val . '</option>';
                  }
                }
                ?>

              </select>
            </div>

            <div class="form-group">

              <label for="amount" class="small"><?= lang('Crm.amount') ?> *</label>
              <div class="input-group mb-3 ">
                <input class="form-control" id="amount" type="text" name="amount" value="<?= $opportunityData['amount'] ?>" autocomplete="off" required>
                <select class="form-control col-3 " id="sel1" name="currency">
                  <?php

                  if (is_array($currencies)) {
                    foreach ($currencies as $row) {
                      echo ' <option value="' . $row['currency_code'] . '"' . ($opportunityData['currency'] == $row['currency_code']? " selected" : "") . '>' . $row['currency_code'] . '</option>';
                    }
                  }

                  if(empty($checkCurrency)){
                    echo'<option value="'.$opportunityData['currency'].'" selected>'.$opportunityData['currency'].'</option>';
                    
                  }

                  ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="probability" class="small"><?= lang('Crm.probability') ?> *</label>
              <input class="form-control" id="probability" type="number" name="probability" value="<?= $opportunityData['probability'] ?>" autocomplete="off" min="0" max="100" required>
            </div>

          </div>

          <div class="col-sm-12">

            <div class="form-group">
              <label for="description" class="small"><?= lang('Crm.description') ?></label>
              <textarea class="form-control" id="description" rows="3" name="description"><?= $opportunityData['description'] ?></textarea>
            </div>

            <hr class=" border-muted">
          </div>

        </div>

        <div class="col-sm-4 row ">

          <div class="col-sm-12 ">

            <?php if (userAdmin()) : ////if allowed to edit  
            ?>

              <?php if (isset($opportunityData['user_id'])) : // if associated user exists 
              ?>

                <input type="hidden" id="userId" name="userid" value="<?= $opportunityData['user_id'] ?>">

                <div class="form-group">
                  <label for="findUser" class="small"><?= lang('Crm.assignedUser') ?>: </label>

                  <div class="input-group  mb-0">
                    <input id="findUser" type="text" name="userfullname" class="form-control" value="<?= $opportunityData['user_full_name'] ?>" autocomplete="off">
                    <div class="input-group-append">
                      <span onclick="removeAssignedUser()" title="<?= lang('Crm.delete') ?>" class="input-group-text"><i style="font-size:12px" class="fa">&#xf00d;</i></span>
                    </div>
                  </div>
                  <div id="resultUser"></div>
                </div>

              <?php else : //if associated user not exists 
              ?>

                <input type="hidden" id="userId" name="userid" value="0">

                <div class="form-group">
                  <label for="findUser" class="small"><?= lang('Crm.assignedUser') ?>: </label>

                  <div class="input-group  mb-0">
                    <input id="findUser" type="text" name="userfullname" class="form-control" placeholder="<?= lang('Crm.startWriteName') ?>" autocomplete="off">
                    <div class="input-group-append">
                      <span onclick="removeAssignedUser()" title="<?= lang('Crm.delete') ?>" class="input-group-text"><i style="font-size:12px" class="fa">&#xf00d;</i></span>
                    </div>
                  </div>
                  <div id="resultUser"></div>
                </div>


              <?php endif; ?>


            <?php else : ////if not allowed to edit  
            ?>

              <input type="hidden" id="userId" name="userid" value="<?= $opportunityData['user_id']  ?>">

              <div class="form-group">
                <label for="findUser" class="small"><?= lang('Crm.assignedUser'); ?>:</label>
                <input type="text" class="form-control" name="userfullname" id="findUser" value="<?= $opportunityData['user_full_name']  ?>" readonly>
              </div>


            <?php
            endif;

            ?>
            <input type="hidden" id="parentId" name="parentid" value="<?= $opportunityData['parent_id']  ?>">


            <div class="form-group">
              <label for="parentType" class="small"><?= lang('Crm.parent') ?>:</label>
              <select id="parentType" class="form-control" name="parenttype">

                <?php
                if (is_array($allowedParents)) {
                  foreach ($allowedParents as $row) {
                    echo ' <option value="' . $row['id'] . '"' . ($opportunityData['parent_type'] == $row['id'] ? " selected" : "") . '>' . lang('Crm.allParentTypes')[$row['id']] . '</option>';
                  }
                }
                ?>

              </select>
            </div>

            <div class="form-group">
              <label for="findParent" class="small font-weight-light"><?= lang('Crm.writeNameOrCompany') ?>: </label>

              <div class="input-group  mb-0">
                <input id="findParent" type="text" class="form-control" autocomplete="off" value="<?= $opportunityData['parent_title'] ?>">
                <div class="input-group-append">
                  <span onclick="removeParent()" title="<?= lang('Crm.delete') ?>" class="input-group-text"><i style="font-size:12px" class="fa">&#xf00d;</i></span>
                </div>
              </div>
              <div id="resultParent"></div>
            </div>


          </div>
        </div>



      </div>

    </form>

  </div>




  <script>
    var findUserUrl = "<?= base_url('ajax/search-assigned-user') ?>";
    var findParentUrl = "<?= base_url('ajax/search-parent') ?>";
  </script>