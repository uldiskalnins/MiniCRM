</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">

    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><?= lang('Crm.controlPanel') ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.users') ?></li>
    </ul>



    <div class="row pl-3 pr-3 pb-3 ">

      <div class="col-sm-12">

        <?= view('default/crm/crm_message_box.php') ?>





      
      <div class="pt-1 pb-3 float-right ">
        <a type="button" href="<?= base_url('admin/new-user'); ?>" class="btn btn-success btn-sm"><i class='far fas fa-plus' style='font-size:12px'></i> <?= lang('Crm.newUser') ?></a>
      </div>



      <div class="card w-100 rounded-0 border-0 ">
      <div class="card-body p-1 table-responsive-md">


      <table class="table table-sm table-hover ">
        <thead class="thead-light">
          <tr>
            <th class="pl-2 small">ID</th>
            <th class="small"><?= lang('Crm.name') ?></th>
            <th class="small"><?= lang('Crm.email') ?></th>
            <th class="small"><?= lang('Crm.position') ?></th>
            <th class="small"><?= lang('Crm.phone') ?></th>
            <th class="small"><?= lang('Crm.active') ?></th>
            <th class="small"><?= lang('Crm.userRightsLevel') ?></th>
          </tr>
        </thead>

        <tbody>

          <?php
          if (is_array($users)) {
            foreach ($users as $row) {

              echo '
              <tr>
                <td class="pl-2">' . $row['id'] . '</td>
                <td><a href="' . base_url('admin/edit-user') . '/' . $row['id'] . '" >' . $row['name'] . ' ' . $row['surname'] . '</a></td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['position'] . '</td>
                <td>' . $row['phone'] . '</td>';

                if ($row['active'] == 1) {echo '<td>' . lang('Crm.yes') . '</td>';}
                else {echo '<td>' . lang('Crm.no') . '</td>';}

                echo '<td>' . lang('Crm.rightsLevelsWords')[$row['user_rights']] . '</td>
              </tr>
          ';
            }
          }

          ?>


        </tbody>
      </table>






    </div>


  </div>


</body>

</html>