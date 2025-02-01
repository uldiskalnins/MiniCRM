<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/<?= session('langCode') ?>.js"></script>


<style>
  .modal-dialog {
    position: fixed;
    margin: auto;
    width: 320px;
    height: 100%;
    right: 0px;
  }

  .modal-content {
    height: 100%;
  }
</style>

</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">


    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle'); ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.editTask'); ?></li>
    </ul>

    <form action="<?= base_url('crm/activities/tasks/save/'); ?>" id="addForm" method="post">


      <div class="row pl-3 pr-3 pb-3 ">



        <?= csrf_field() ?>



        <div class="col-sm-12">

          <button type="submit" id="sbutton" class="btn btn-info btn-sm float-right"><i class='fas fa-save' style='font-size:12px'></i> <?= lang('Crm.save') ?></button>

        </div>


        <div class="col-sm-4 ">

          <div class="form-group">
            <label for="title" class="small"><?= lang('Crm.title') ?> *</label>
            <input type="text" class="form-control" name="title" id="title" value="<?= $taskData['title'] ?>" required>
          </div>


          <div class="form-group">
            <label for="status" class="small"><?= lang('Crm.priority') ?> </label>
            <select class="form-control" id="priority" name="priority">
              <option value="0" <?= ($taskData['priority'] == 0 ? "selected" : "") ?>><?= lang('Crm.taskPriorityList')[0] ?></option>
              <option value="1" <?= ($taskData['priority'] == 1 ? "selected" : "") ?>><?= lang('Crm.taskPriorityList')[1] ?></option>
              <option value="2" <?= ($taskData['priority'] == 2 ? "selected" : "") ?>><?= lang('Crm.taskPriorityList')[2] ?></option>
              <option value="3" <?= ($taskData['priority'] == 3 ? "selected" : "") ?>><?= lang('Crm.taskPriorityList')[3] ?></option>
            </select>
          </div>


          <div class="form-group">
            <label for="description" class="small"><?= lang('Crm.description') ?></label>
            <textarea class="form-control" id="description" rows="3" name="description"><?= $taskData['description'] ?></textarea>
          </div>


          <hr class=" border-muted">

        </div>

        <div class="col-sm-4 ">

          <div class="form-group">
            <label for="status" class="small"><?= lang('Crm.status') ?></label>
            <select class="form-control" id="status" name="status">
              <option value="0" <?= ($taskData['status'] == 0 ? "selected" : "") ?>><?= lang('Crm.taskStatusList')[0] ?></option>
              <option value="1" <?= ($taskData['status'] == 1 ? "selected" : "") ?>><?= lang('Crm.taskStatusList')[1] ?></option>
              <option value="2" <?= ($taskData['status'] == 2 ? "selected" : "") ?>><?= lang('Crm.taskStatusList')[2] ?></option>
              <option value="3" <?= ($taskData['status'] == 3 ? "selected" : "") ?>><?= lang('Crm.taskStatusList')[3] ?></option>
              <option value="4" <?= ($taskData['status'] == 4 ? "selected" : "") ?>><?= lang('Crm.taskStatusList')[4] ?></option>
            </select>
          </div>


          <div class="form-group">
            <label for="startDate" class="small"><?= lang('Crm.startDateTime') ?></label>
            <input class="form-control" id="startDate" type="text" name="startdate" value="<?= $taskData['start_date'] ?>" autocomplete="off">
          </div>


          <div class="form-group">
            <label for="endDate" class="small"><?= lang('Crm.endDateTime') ?></label>
            <input class="form-control" id="endDate" type="text" name="enddate" value="<?= $taskData['end_date'] ?>" autocomplete="off">
          </div>




        </div>

        <div class="col-sm-4 ">


          <div class="form-group">


            <?php if (userAdmin()) : ////if allowed to edit  
            ?>

              <label class="small"><?= lang('Crm.assignedUser') ?>: </label>

              <?php if (!empty($taskData['user_id'])) : // if associated user exists 
              ?>

                <input type="hidden" id="userId" name="userid" value="<?= $taskData['user_id'] ?>">


                <div class="input-group  mb-0">
                  <input id="findUser" type="text" class="form-control" value="<?= $taskData['user_full_name'] ?> " autocomplete="off">
                  <div class="input-group-append">
                    <span onclick="removeAssignedUser()" title="<?= lang('Crm.delete') ?>" class="input-group-text"><i style="font-size:12px" class="fa">&#xf00d;</i></span>
                  </div>
                </div>
                <div id="resultUser"></div>


              <?php else : //if associated user not exists 
              ?>


                <input type="hidden" id="userId" name="userid" value="">


                <div class="input-group  mb-0">
                  <input id="findUser" type="text" class="form-control" placeholder="<?= lang('Crm.startWriteName') ?>" autocomplete="off">
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
                <input type="text" class="form-control" id="findUser" value="<?= session()->get('userName') ?> <?= session()->get('userSurname') ?>" readonly>
              </div>


            <?php endif; ?>

          </div>




          <input type="hidden" id="parentId" name="parentid" value="<?= $taskData['parent_id'] ?>">


          <div class="form-group">
            <label for="parentType" class="small"><?= lang('Crm.parent') ?>:</label>
            <select id="parentType" class="form-control" name="parenttype">

            <?php 
              if (is_array($allowedParents))
              {
                foreach ($allowedParents as $row)
                {
                  echo ' <option value="' . $row->id . '"' . ($taskData['parent_type'] == $row->id ? " selected" : "") . '>' . lang('Crm.allParentTypes')[$row->id] . '</option>';
                }
              }
              ?>

            </select>
          </div>

          <div class="form-group">
            <label for="findParent" class="small text-muted"><?= lang('Crm.writeNameOrCompany') ?>: </label>

            <div class="input-group  mb-0">
              <input id="findParent" type="text" class="form-control" autocomplete="off" value="<?= $taskData['parent_title']  ?>">
              <div class="input-group-append">
                <span onclick="removeParent()" title="<?= lang('Crm.delete') ?>" class="input-group-text"><i style="font-size:12px" class="fa">&#xf00d;</i></span>
              </div>
            </div>
            <div id="resultParent"></div>
          </div>

        </div>

      </div>


      <input type="hidden" id="id" name="id" value="<?= $taskData['id'] ?>">

    </form>

  </div>



  <script>
    var findUserUrl = "<?= base_url('ajax/search-assigned-user') ?>";
    var findParentUrl = "<?= base_url('ajax/search-parent') ?>";

    $(document).ready(function() {

      $("#startDate").flatpickr({
        allowInput: true,
        "locale": "<?= session('langCode') ?>",
        enableTime: true,
        time_24hr: true,
        dateFormat: "Y-m-d H:i",
      });
      $("#endDate").flatpickr({
        allowInput: true,
        "locale": "<?= session('langCode') ?>",
        enableTime: true,
        time_24hr: true,
        dateFormat: "Y-m-d H:i",
      });


    });
  </script>

