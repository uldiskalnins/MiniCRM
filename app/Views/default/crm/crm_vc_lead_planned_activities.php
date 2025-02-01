<div class="card rounded-0">
    <div class="card-header p-2 rounded-0 ">

        <?= lang('Crm.activities') ?>
        <span class="float-right">
            <a href="<?= base_url('crm/activities/emails/new') ?>?leadid=<?= $leadData['id'] ?>"><i class='far fa-envelope' style='font-size:12px'></i></a>
            <a href="<?= base_url('crm/activities/calls/new') ?>?leadid=<?= $leadData['id'] ?>"><i class='fas fa-phone pl-3' style='font-size:12px'></i></a>
            <a href="<?= base_url('crm/activities/meetings/new') ?>?leadid=<?= $leadData['id'] ?>"><i class='far fa-calendar-alt pl-3' style='font-size:12px'></i></a>
        </span>

    </div>
    <div class="card-body">

        <table class="table table-borderless table-sm">

            <?php foreach ($plannedActivities as $pa) { ?>
                <tr>
                    <td>
                    <?php
                        if ($pa->activity_type == 'c') 
                        {
                            echo '<span><i class="fas fa-phone" style="font-size:12px"></i> <a  class="font-weight-normal" href="' . base_url('crm/activities/call/') . '' . $pa->id . '">' . $pa->title . '</a></span><br>';
                        } elseif ($pa->activity_type == 'm') 
                        {
                            echo '<span><i class="far fa-calendar-alt" style="font-size:12px"></i> <a  class="font-weight-normal" href="' . base_url('crm/activities/meeting/') . '' . $pa->id . '">' . $pa->title . '</a></span><br>';

                        } elseif ($pa->activity_type == 'e') 
                        {
                            echo '<span><i class="far fa-envelope" style="font-size:12px"></i> <a  class="font-weight-normal" href="' . base_url('crm/activities/email/') . '' . $pa->id . '">' . $pa->title . '</a></span><br>';
                        }

                        echo'<span class="small"><a href="' . base_url('crm/user/') . '/' . $pa->user_id . '">' . $pa->user_full_name . '</a>  
                        <span class="text-muted">' . showDateAndTime($pa->start_date) . '</span>
                       ';
                        ?>
                    </td>
                </tr>

            <?php } ?>

        </table>

    </div>

</div>