<div class="row px-2"> <!----  DARBĪBU VĒSTURE  -->

  <div class="card w-100 rounded-0 ml-2">
    <div class="card-header p-1 rounded-0 "><?= lang('Crm.actionHistory') ?></div>
    <div class="card-body p-0 table-responsive-md">

      <table class="table table-sm mxz-0">
        <thead class="">
          <tr>
            <th class="small text-muted col-sm-8"><?= lang('Crm.action') ?></th>
            <th class="small text-muted col-sm-2"><?= lang('Crm.user') ?></th>
            <th class="small text-muted col-sm-2"><?= lang('Crm.date') ?></th>

          </tr>
        </thead>
        <tbody>

          <?php

          if (is_array($historyList)) {

            foreach ($historyList as $row) {

              echo '
               <tr>
                <td class="small">' . $actionHistoryLog->decodeData($row) . '</td>
                <td class="small"><a href="' . base_url('crm/user/') . $row->user_id  . '">' . $row->user_full_name . '</a></td>
                <td class="small">' . showDateAndTime($row->creation_date) . '</td>
               </tr>
             ';
            }
          }

?>

        </tbody>
      </table>

    </div>

    <div class="a">
      <a class="ml-2 mb-2" data-toggle="collapse" data-target="#notesForm"><?= lang('Crm.note') ?> </a>
      <div class=" collapse" id="notesForm">
        <form id="historyNotesForm" enctype="multipart/form-data">


          <div class="input-group p-2">

            <input type="text" maxlength="500" name="note" id="historyNote" class="form-control rounded-0" autocomplete="off" required>
            <div class="input-group-append">
              <button type="submit" class="btn btn-light btn-outline-secondary rounded-0"><?= lang('Crm.save') ?></button>
            </div>
          </div>
        </form>
        <div id="historyNoteResponse"></div>
      </div>
    </div>



    <?php if ($countHistory > 5) : ?>

      <span class="text-center m-1">
        <a class="sm " href="<?= base_url('crm/action-history/') ?><?= $historyId ?>/<?= $historyType ?>"><?= lang('Crm.showAll') ?> (<?= $countHistory ?>)</a>
      </span>

    <?php endif; ?>

  </div>

</div>

<script>
  var historyNotePostUrl = "<?= base_url('ajax/add-history-note/') ?><?= $historyId ?>/<?= $historyType ?>";
</script>
