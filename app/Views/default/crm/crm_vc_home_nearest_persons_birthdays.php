<div class="col-sm-12 col-md-6 col-lg-4 dragparent" id="pnpb">
  <div class="card rounded-0 col-12 p-0 mt-2 dragchild" id="npb">
    <div class="card-header p-2 rounded-0 ">

      <?= lang('Crm.nearestPersonsBirthdays') ?>


    </div>
    <div class="card-body">

      <table class="table table-borderless table-sm">

        <?php foreach ($persons as $row) { ?>
          <tr>
            <td>
              <?php

              echo '<span><a  class="font-weight-normal" href="' . base_url('crm/person/') . '' . $row->id . '">' . $row->full_name .'</a></span><br>';
              echo '<span class="text-muted">' . showDateAndTime($row->birthday, 4) .'</span>';
              ?>
            </td>
          </tr>

        <?php } ?>

      </table>

    </div>

  </div>
</div>