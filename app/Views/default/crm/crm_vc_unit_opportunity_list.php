   <div class="row px-2"> <!----  IESPĒJAS  -->

     <div class="card w-100 rounded-0 ml-2">
       <div class="card-header p-1 rounded-0 "><?= lang('Crm.opportunities') ?>
        <span class="float-right pr-1">
          <a href="<?= base_url('crm/opportunities/new') ?>?<?= $getIdentifier[$parentType] ?>=<?= $parentId ?>"><i class="fas fa-plus " style="font-size:12px"></i></a>
        </span>
        </div>
       <div class="card-body p-0 table-responsive-md">

         <table class="table table-sm mx-0">
           <thead class="">
             <tr>
               <th class="small text-muted "><?= lang('Crm.title') ?></th>
               <th class="small text-muted "><?= lang('Crm.stage') ?></th>
               <th class="small text-muted "><?= lang('Crm.closeDate') ?></th>
               <th class="small text-muted "><?= lang('Crm.amount') ?></th>
             </tr>
           </thead>
           <tbody>

             <?php
              if (is_array($opportunitiesList)) {

                foreach ($opportunitiesList as $row) {

                  echo '
                    <tr>
                      <td><a href="' . base_url('crm/opportunity/') . $row['id'] . '">' . $row['title'] . '</a></td>
                      <td>' . lang('Crm.opportunityStageList')[$row['stage']]. '</td>
                      <td>' . showDateAndTime($row['close_date'],1) . '</td>
                      <td>' . showMoney($row['amount'], $row['currency']) . '</td>
                    </tr>
                  ';
                }
              }

              ?>

           </tbody>
         </table>
       </div>



       <?php if ($countOpportunities > 5) : ?>

        <span class="text-center m-1">

        <a class="sm " href="<?= base_url('crm/unit/opportunities/') ?><?= $parentType ?>/<?= $parentId ?>"><?= lang('Crm.showAll') ?> (<?= $countOpportunities ?>)</a>
        </span>

        <?php endif; ?>
     </div>
   </div>