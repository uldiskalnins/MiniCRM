<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/<?= lang('Crm.langCode')  ?>.js"></script>



</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">


    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('crm/activities/calls/') ?>"><?= lang('Crm.calls') ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.edit') ?></li>
    </ul>

    <form action="<?= base_url('crm/activities/calls/save') ?>" id="addForm" method="post">


      <div class="row pl-3 pr-3 pb-3 ">



        <?= csrf_field() ?>

        <input type="hidden" id="CallId" name="id" value="<?= $callData['id'] ?>">

        <div class="col-sm-12">

          <button type="submit" id="sbutton" class="btn btn-info btn-sm float-right"><i class='fas fa-save' style='font-size:12px'></i> <?= lang('Crm.save') ?> </button>

        </div>

        <div class="col-sm-4 ">




          <div class="form-group">
            <label for="title" class="small"><?= lang('Crm.title') ?> *</label>
            <input type="text" class="form-control" name="title" id="title" value="<?= $callData['title'] ?>" required>
          </div>




          <div class="form-group">
            <label for="type" class="small"><?= lang('Crm.type') ?></label>
            <select class="form-control" id="type" name="type">

              <?php
              echo '<option value="0" ' . ($callData['type'] == 0 ? "selected" : "") . '>' . lang('Crm.typeList')[0] . '</option>';
              echo '<option value="1" ' . ($callData['type'] == 1 ? "selected" : "") . '>' . lang('Crm.typeList')[1] . '</option>';
              ?>

            </select>
          </div>



          <div class="form-group">
            <label for="description" class="small"><?= lang('Crm.description') ?></label>
            <textarea class="form-control" id="description" rows="3" name="description"><?= $callData['description'] ?></textarea>
          </div>


          <hr class=" border-muted">


        </div>


        <div class="col-sm-4 ">


          <div class="form-group">
            <label for="status" class="small"><?= lang('Crm.status') ?> </label>
            <select class="form-control" id="status" name="status">

              <?php
              echo '<option value="0" ' . ($callData['status'] == 0 ? "selected" : "") . '>' . lang('Crm.statusList')[0] . '</option>';
              echo '<option value="1" ' . ($callData['status'] == 1 ? "selected" : "") . '>' . lang('Crm.statusList')[1] . '</option>';
              echo '<option value="2" ' . ($callData['status'] == 2 ? "selected" : "") . '>' . lang('Crm.statusList')[2] . '</option>';
              ?>

            </select>
          </div>

          <div class="form-group">
            <label for="startDate" class="small"><?= lang('Crm.startDateTime') ?> *</label>
            <input class="form-control" id="startDate" type="text" name="startdate" autocomplete="off" value="<?= $callData['start_date'] ?>" required>
          </div>


          <div class="form-group">
            <label for="endDate" class="small"><?= lang('Crm.endDateTime') ?> *</label>
            <input class="form-control" id="endDate" type="text" name="enddate" autocomplete="off" value="<?= $callData['end_date'] ?>" required>
          </div>




        </div>

        <div class="col-sm-4 ">


          <div class="form-group">


            <?php if (userAdmin()) : ////if allowed to edit  
            ?>

              <label class="small"><?= lang('Crm.assignedUser') ?>: </label>

              <?php if (!empty($callData['user_id'])) : // if associated user exists 
              ?>

                <input type="hidden" id="userId" name="userid" value="<?= $callData['user_id'] ?>">


                <div class="input-group  mb-0">
                  <input id="findUser" type="text" name="userfullname" class="form-control" value="<?= $callData['user_full_name'] ?> " autocomplete="off">
                  <div class="input-group-append">
                    <span onclick="removeAssignedUser()" title="<?= lang('Crm.delete') ?>" class="input-group-text"><i style="font-size:12px" class="fa">&#xf00d;</i></span>
                  </div>
                </div>
                <div id="resultUser"></div>


              <?php else : //if associated user not exists 
              ?>


                <input type="hidden" id="userId" name="userid" value="">


                <div class="input-group  mb-0">
                  <input id="findUser" type="text" name="userfullname" class="form-control" placeholder="<?= lang('Crm.startWriteName') ?>" autocomplete="off">
                  <div class="input-group-append">
                    <span onclick="removeAssignedUser()" title="<?= lang('Crm.delete') ?>" class="input-group-text"><i style="font-size:12px" class="fa">&#xf00d;</i></span>
                  </div>
                </div>
                <div id="resultUser"></div>




              <?php endif; ?>
            <?php else : ////if not allowed to edit  
            ?>

              <input type="hidden" id="userId" name="userid" value="<?= session()->get('userId') ?>">

              <div class="form-group">
                <label for="findUser" class="small"><?= lang('Crm.assignedUser'); ?>:</label>
                <input type="text" class="form-control" name="userfullname" id="findUser" value="<?= session()->get('userName') ?> <?= session()->get('userSurname') ?>" readonly>
              </div>


            <?php endif; ?>

          </div>

          <?php

          //Secondary parent tiek ņemts vērā tikai ja primārais ir persona un tas vienmēr var būt tikai uzņēmums
          ?>


          <input type="hidden" id="secondaryParentaccountId" name="secondaryparentaccountid" value="<?= $secondaryParent['parent_id'] ?? 0; ?>">
          <input type="hidden" id="parentId" name="parentid" value="<?= $callData['parent_id'] ?>">


          <div class="form-group">
            <label for="parentType" class="small"><?= lang('Crm.parent') ?>:</label>
            <select id="parentType" class="form-control" name="parenttype">

              <?php
              if (is_array($allowedParents)) {
                foreach ($allowedParents as $row) {
                  echo ' <option value="' . $row->id . '"' . ($callData['parent_type'] == $row->id ? " selected" : "") . '>' . lang('Crm.allParentTypes')[$row->id] . '</option>';
                }
              }
              ?>

            </select>
          </div>

          <div class="form-group">
            <label for="findParent" class="small font-weight-light"><?= lang('Crm.writeNameOrCompany') ?>: </label>

            <div class="input-group  mb-0">
              <input id="findParent" type="text" class="form-control" autocomplete="off" value="<?= $callData['parent_title'] ?>">
              <div class="input-group-append">
                <span onclick="removeParent()" title="<?= lang('Crm.delete') ?>" class="input-group-text"><i style="font-size:12px" class="fa">&#xf00d;</i></span>
              </div>
            </div>
            <div id="resultParent"></div>
          </div>

          <div id="spaDiv" class="collapse <?= !empty($secondaryParent['parent_id']) ? 'show' : '' ?>">
            <div class="form-group">
              <label for="secondaryParentAccount" class="small font-weight-light"><?= lang('Crm.secondaryParentAccount') ?>: </label>

              <div class="input-group  mb-0">
                <input id="secondaryParentAccount" type="text" class="form-control" autocomplete="off" value="<?= $secondaryParent['parent_title'] ?? '' ?>" readonly>
                <div class="input-group-append">
                  <span onclick="removeSecondaryParentAccount()" title="<?= lang('Crm.delete') ?>" class="input-group-text"><i style="font-size:12px" class="fa">&#xf00d;</i></span>
                </div>
              </div>
            </div>
          </div>


        </div>


      </div>



  </div>

  </form>

  </div>




  <script>
    var findUserUrl = "<?= base_url('ajax/search-assigned-user') ?>";
    var findParentUrl = "<?= base_url('ajax/search-parent') ?>";



    $(document).ready(function() {

      const fpStartDate = $("#startDate").flatpickr({
        allowInput: true,
        "locale": "<?= lang('Crm.langCode') ?>",
        enableTime: true,
        time_24hr: true,
        dateFormat: "Y-m-d H:i",
        onChange: function(selectedDates, dateStr, instance) {
          if (selectedDates.length > 0) {
            var endDate = new Date(selectedDates[0]);
            endDate.setMinutes(endDate.getMinutes() + 10);

            fpEndDate.setDate(endDate);
          } else {
            fpEndDate.clear();
          }
        }
      });

      const fpEndDate = $("#endDate").flatpickr({
        allowInput: true,
        "locale": "<?= lang('Crm.langCode') ?>",
        enableTime: true,
        time_24hr: true,
        dateFormat: "Y-m-d H:i",

      });

    });
  </script>