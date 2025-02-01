<div class="card rounded-0">
  <div class="card-header p-2 rounded-0 ">

    <?= lang('Crm.activitiesHistory') ?>

  </div>
  <div class="card-body">

    <table class="table table-borderless table-sm">

      <?php foreach ($activitiesHistory as $ah) { ?>
        <tr>
          <td>
            <?php
            if ($ah->activity_type == 'c') {
              echo '<span><i class="fas fa-phone" style="font-size:12px"></i> <a  class="font-weight-normal" href="' . base_url('crm/activities/call/') . '' . $ah->id . '">' . $ah->title . '</a></span><br>';
            } elseif ($ah->activity_type == 'm') {
              echo '<span><i class="far fa-calendar-alt" style="font-size:12px"></i> <a  class="font-weight-normal" href="' . base_url('crm/activities/meeting/') . '' . $ah->id . '">' . $ah->title . '</a></span><br>';
            } elseif ($ah->activity_type == 'e') {
              echo '<span><i class="far fa-envelope" style="font-size:12px"></i> <a  class="font-weight-normal" href="' . base_url('crm/activities/email/') . '' . $ah->id . '">' . $ah->title . '</a></span><br>';
            }

            echo '<span class="small"><a href="' . base_url('crm/user/') . '/' . $ah->user_id . '">' . $ah->user_full_name . '</a>  
                  <span class="text-muted">' . showDateAndTime($ah->start_date) . '</span>
                  ';
            ?>
          </td>
        </tr>

      <?php } ?>

    </table>

  </div>

  <?php if ($countHistory > 5) : ?>

    <span class="text-center m-1">
      <a class="sm " href="<?= base_url('crm/activities/history/') ?><?= $type ?>/<?= $personData['id'] ?>"><?= lang('Crm.showAll') ?> (<?= $countHistory ?>)</a>

    </span>

  <?php endif; ?>

</div>