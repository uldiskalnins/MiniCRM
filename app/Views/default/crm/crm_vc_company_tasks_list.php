<div class="card rounded-0">
  <div class="card-header p-2 rounded-0 ">
    <?= lang('Crm.tasks') ?>


    <span class="float-right">
      <a href="<?= base_url('crm/activities/tasks/new') ?>?companyid=<?= $companyData['id'] ?>"><i class='fas fa-plus pl-3' style='font-size:12px'></i></a>
    </span>


  </div>
  <div class="card-body">

    <table class="table table-borderless table-sm">

      <?php foreach ($tasks as $task) { ?>
        <tr>
          <td>
            <?php


            echo '<span> <a class="font-weight-normal" href="' . base_url('crm/activities/task/') . '/' . $task->id . '">' . $task->title . '</a> </span><br>
            <span class="small"><a href="' . base_url('crm/user/') . '/' . $task->user_id . '">' . $task->user_full_name . '</a>';
            echo !is_null($task->end_date) ? '&nbsp;<span class="text-muted"> ' . showDateAndTime($task->end_date, 1) . '</span>' : '';
            echo '&nbsp;' . lang('Crm.taskStatusList')[$task->status] . '</span>
            ';

            ?>
          </td>
        </tr>

      <?php } ?>

    </table>



  </div>


  <?php if ($countTasks > 5) : ?>

    <span class="text-center m-1">

      <a class="sm " href="<?= base_url('crm/unit/tasks/') ?><?= $type ?>/<?= $companyData['id'] ?>"><?= lang('Crm.showAll') ?> (<?= $countTasks ?>)</a>
    </span>

  <?php endif; ?>

</div>