   <div class="row px-2"> <!----  Kontaktpersonas  -->

     <div class="card w-100 rounded-0 ml-2">
       <div class="card-header p-1 rounded-0 "><?= lang('Crm.contactPersons') ?>
       <span class="float-right pr-1">
          <a href="<?= base_url('crm/persons/new') ?>?companyid=<?= $companyData['id'] ?>"><i class="fas fa-plus " style="font-size:12px"></i></a>
        </span>
      </div>
       <div class="card-body p-0 table-responsive-md">

         <table class="table table-sm mx-0">
           <thead class="">
             <tr>
               <th class="small text-muted "><?= lang('Crm.name') ?></th>
               <th class="small text-muted "><?= lang('Crm.position') ?></th>
               <th class="small text-muted "><?= lang('Crm.email') ?></th>
               <th class="small text-muted "><?= lang('Crm.phone') ?></th>
             </tr>
           </thead>
           <tbody>

             <?php
              if (is_array($contactPersonsList)) {

                foreach ($contactPersonsList as $row) {

                  echo '
                    <tr>
                      <td><a href="' . base_url('crm/person') . '/' . $row['id'] . '">' . $row['name'] . ' ' . $row['surname'] . '</a></td>
                      <td>' . $row['position'] . '</td>
                      <td><a href="mailto:' . $row['email'] . '">' . $row['email'] . '</a></td>
                      <td><a href="tel:' . $row['phone'] . '">' . $row['phone'] . '</a></td>
                    </tr>
                  ';
                }
              }

              ?>

           </tbody>
         </table>
       </div>
     </div>
   </div>