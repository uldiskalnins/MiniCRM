<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.1/dist/summernote.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.1/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.1/dist/summernote-bs4.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.1/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.1/dist/lang/summernote-<?= lang('Crm.localeSummernote') ?>.js"></script>

</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">


    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('crm/activities/emails') ?>"><?= lang('Crm.emails') ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.edit'); ?></li>
    </ul>

    <form action="<?= base_url('crm/activities/emails/save/') ?>" id="addForm" method="post" enctype="multipart/form-data">


      <div class="row pl-3 pr-3 pb-3 ">



        <?= csrf_field() ?>

        <input type="hidden" id="id" name="id" value="<?= $emailData['id'] ?>">

        <div class="col-sm-12">

          <button type="submit" id="sbutton" class="btn btn-info btn-sm float-right"><i class='fas fa-save' style='font-size:12px'></i> <?= lang('Crm.save') ?> </button>

        </div>



        <div class="col-sm-8 row">

          <div class="col-sm-6 ">

            <div class="form-group">
              <label for="fromEmail" class="small"><?= lang('Crm.fromEmail') ?> *</label>
              <input class="form-control" id="fromEmail" type="text" name="fromemail" autocomplete="off" required value="<?= $emailData['from_email'] ?>">
            </div>



            <div class="form-group">
              <label for="ccEmail" class="small"><?= lang('Crm.ccEmail') ?> </label>
              <input type="text" class="form-control" name="cc" id="ccEmail" value="<?= $emailData['cc'] ?>">
            </div>



          </div>

          <div class="col-sm-6">


            <div class="form-group">
              <label for="toEmail" class="small"><?= lang('Crm.toEmail') ?> *</label>
              <input class="form-control" id="toEmail" type="text" name="toemail" autocomplete="off" required value="<?= $emailData['to_email'] ?>">
            </div>



            <div class="form-group">
              <label for="bccEmail" class="small"><?= lang('Crm.bccEmail') ?> </label>
              <input type="text" class="form-control" name="bcc" id="bccEmail" value="<?= $emailData['bcc'] ?>">
            </div>


          </div>


          <div class="col-sm-12">



            <div class="form-group">
              <label for="subject" class="small"><?= lang('Crm.emailSubject') ?> *</label>
              <input type="text" class="form-control" name="subject" id="subject" value="<?= $emailData['subject'] ?>" required>
            </div>


            <div class="form-group">
              <label for="body" class="small"><?= lang('Crm.emailBody') ?> *</label>
              <textarea class="form-control" id="body" rows="3" name="body" required><?= esc($emailData['body']) ?></textarea>
            </div>


            <div class="form-group" id="fileUpload">
              <label for="file" class="small"><?= lang('Crm.files') ?> <i title="<?= $allowedUploadFileTypes ?>" class='far fa-question-circle' style='font-size:14px'></i></label>
              <?php

              if (!empty($emailFiles)) {

                echo '
                                <table class="table table-borderless table-sm" id="fileList">
                                <tbody>
                                ';

                foreach ($emailFiles as $file) {

                  $shortFileName = shortEmailFileName($file['file_name']);
                  echo '<tr id="fileId' . $file['id'] . '"><td><i style="font-size:16px" class="fas">&#xf0c6;</i> <a href="' . base_url('/uploads/email/') . $file['file_name'] . '" download="' . $shortFileName . '">' . $shortFileName . '</a> <i onclick="removeFile(' . $file['id'] . ')" title="' . lang('Crm.delete') . '" role="button" style="font-size:16px" class="fa text-muted">&#xf00d;</i>
                  </td></tr>';
                }

                echo '</tbody>
                </table>';
              }

              //<div class="custom-file"> <input type="file" name="file[]" id="file"></div>
              ?>


            </div>

            <div class=" mx-auto w-75 mb-4">
              <button type="button" class="add_more form-control small rounded-0"> <?= lang('Crm.addFileField') ?></button>
            </div>

          </div>



        </div>


        <div class="col-sm-4 ">

          <div class="form-group">
            <label for="action" class="small"><?= lang('Crm.emailAction') ?> </label>
            <select class="form-control" id="action" name="action">
              <option value="0"><?= lang('Crm.emailActionList')[0] ?></option>
              <option value="1"><?= lang('Crm.emailActionList')[1] ?></option>
              <option value="2"><?= lang('Crm.emailActionList')[2] ?></option>

            </select>
          </div>




          <div class="form-group">


            <?php if (userAdmin()) : ////if allowed to edit  
            ?>

              <label class="small"><?= lang('Crm.assignedUser') ?>: </label>

              <?php if (!empty($emailData['user_id'])) : // if associated user exists 
              ?>

                <input type="hidden" id="userId" name="userid" value="<?= $emailData['user_id'] ?>">


                <div class="input-group  mb-0">
                  <input id="findUser" type="text" name="userfullname" class="form-control" value="<?= $emailData['user_full_name'] ?> " autocomplete="off">
                  <div class="input-group-append">
                    <span onclick="removeAssignedUser()" title="<?= lang('Crm.delete') ?>" class="input-group-text"><i style="font-size:12px" class="fa">&#xf00d;</i></span>
                  </div>
                </div>
                <div id="resultUser"></div>


              <?php else : //if associated user not exists 
              ?>


                <input type="hidden" id="userId" name="userid" value="">


                <div class="input-group  mb-0">
                  <input id="findUser" type="text" class="form-control" name="userfullname" placeholder="<?= lang('Crm.startWriteName') ?>" autocomplete="off">
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



          <input type="hidden" id="parentId" name="parentid" value="<?= $emailData['parent_id'] ?>">


          <div class="form-group">
            <label for="parentType" class="small"><?= lang('Crm.parent') ?>:</label>
            <select id="parentType" class="form-control" name="parenttype">


              <?php
              if (is_array($allowedParents)) {
                foreach ($allowedParents as $row) {
                  echo ' <option value="' . $row->id . '"' . ($emailData['parent_type'] == $row->id ? " selected" : "") . '>' . lang('Crm.allParentTypes')[$row->id] . '</option>';
                }
              }
              ?>

            </select>
          </div>

          <div class="form-group">
            <label for="findParent" class="small font-weight-light"><?= lang('Crm.writeNameOrCompany') ?>: </label>

            <div class="input-group  mb-0">
              <input id="findParent" type="text" class="form-control" autocomplete="off" value="<?= $emailData['parent_title'] ?>">
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
    var deleteFileUrl = "<?= base_url('ajax/delete-file') ?>";
    var formFiles = <?= count($emailFiles) ?>;


    $(document).ready(function() {

      htmlEditorOn();


      $('.add_more').click(function(e) {
        if (formFiles < 10) {
          $('#fileUpload').append('<div class="custom-file"><input type="file" name="file[]"> <button type="button" onclick="removeFileDiv(this)">X</button></div>');
          formFiles++;
        }
      });


    });

    function removeFileDiv(e) {
      $(e).parent('div').remove();
      formFiles--;
    }

    function htmlEditorOn() {
      $('#body').summernote({
        lang: '<?= lang('Crm.locale') ?>',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    }
  </script>