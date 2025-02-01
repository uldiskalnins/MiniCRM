<nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-topz">

 <a class="navbar-brand" href="<?=base_url('crm')?>">
  <?= lang('Crm.crmTitle')?>
 </a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>


 <div class="collapse navbar-collapse" id="collapsibleNavbar">
  <ul class="navbar-nav">

    <li class="nav-item">
      <a class="nav-link text-light" href="<?=base_url('crm/companies/')?>"><?= lang('Crm.companies')?></a>
    </li>

    <li class="nav-item">
      <a class="nav-link text-light" href="<?=base_url('crm/persons/')?>" ><?= lang('Crm.persons')?></a>
    </li>

    <li class="nav-item">
      <a class="nav-link text-light" href="<?=base_url('crm/leads/')?>" ><?= lang('Crm.leads')?></a>
    </li>

    <li class="nav-item">
      <a class="nav-link text-light" href="<?=base_url('crm/opportunities/')?>" ><?= lang('Crm.opportunities')?></a>
    </li>

   <li class="nav-item dropdown ">
    <a class="nav-link dropdown-toggle text-light" data-toggle="dropdown" href="#" >
      <?= lang('Crm.activities')?>
    </a>
    <div class="dropdown-menu ">
     <a class="dropdown-item" href="<?=base_url('crm/activities/calls/')?>"><?= lang('Crm.calls')?></a>
     <a class="dropdown-item" href="<?=base_url('crm/activities/meetings/')?>"><?= lang('Crm.meetings')?></a>
     <a class="dropdown-item" href="<?=base_url('crm/activities/emails/')?>"><?= lang('Crm.emails')?></a>
     <a class="dropdown-item" href="<?=base_url('crm/activities/tasks/')?>"><?= lang('Crm.tasks')?></a>

    </div>
   </li>
  
  </ul>

  <ul class="nav navbar-nav ml-auto">



   <li class="nav-item dropdown ">
    <a class="nav-link dropdown-toggle text-light" href="#" id="navbardrop" data-toggle="dropdown" href="#"><i class='far fa-user-circle' style='font-size:18px'></i> <?= session()->get('userName').' '. session()->get('userSurname') ?></a>
    <div class="dropdown-menu ">
     <a class="dropdown-item" href="<?=base_url('crm/user/'). session()->get('userId')?>"><?= lang('Crm.profile')?></a>

<?php 

    if (userAdmin()):
?>
     <hr>
     <a class="dropdown-item" href="<?=base_url('admin/')?>"><?= lang('Crm.settings')?></a>

<?php
    endif;
?>

     <hr>
     <a class="dropdown-item" href="<?=base_url('/logout')?>"><?= lang('Crm.logout')?></a>
    </div>
   </li>

  </ul>

 </div>
</nav>