
</head>
<body class="bg-light text-dark" >

<nav class="navbar navbar-expand-md bg-dark navbar-dark ">
 <a class="navbar-brand" href="<?=base_url();?>">
  <?= lang('Crm.crmTitle');?>
 </a>


</nav>


<div class="container bg-white pb-5  mt-3 mb-3 pl-0 pr-0 border">

 <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2">
  <li class="breadcrumb-item"><a href="<?= base_url('crm')?>" ><?= lang('Crm.crmTitle')?></a></li>
  <li class="breadcrumb-item"><a href="<?= base_url('admin')?>" ><?= lang('Crm.controlPanel')?></a></li>
  <li class="breadcrumb-item active"><?= lang('Crm.userCreated')?></li>
 </ul>


 <div class="container pb-3 pt-3 text-center">




   <h4><?= lang('Crm.userCreated') ;?></h4>


 <table class="table">
    <thead class="thead-light">
      <tr>
        <th><?= lang('Crm.email')?></th>
        <th><?= lang('Crm.password')?></th>
        <th><?= lang('Crm.name')?></th>
        <th><?= lang('Crm.position')?></th>
        <th><?= lang('Crm.userRightsLevel')?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?= $newUser['email'] ?></td>
        <td><?= $newUser['password'] ?></td>
        <td><?= $newUser['name'] ?> <?= $newUser['surname'] ?></td>
        <td><?= $newUser['position'] ?></td>
        <td><?= $newUser['rights'] ?></td>
      </tr>

    </tbody>
  </table>

  <div class="pt-5">
   <a type="button" href="<?= base_url('admin/users/');?>" class="btn btn-success float-right"><?= lang('Crm.users');?></a>
  </div>

 </div>


 </div>
</div>

</body>
</html>