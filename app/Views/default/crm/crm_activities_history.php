</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>

  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">

    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item"><a href="<?= base_url($allowedParents[$type]['url']).$id  ?>"><?= $title ?> </a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.activitiesHistory') ?></li>
    </ul>

    <div class="row pl-3 pr-3 pb-3 ">

      <div class="col-sm-12">


        <div class="float-right mr-1">
          <a type="button" title="<?= lang('Crm.newEmail') ?>" class="btn btn-light" href="<?= base_url('crm/activities/emails/new') ?>?<?=$getIdentifier[$type]?>=<?=$id?>"><i class='far fa-envelope' style='font-size:12px'></i></a>
          <a type="button" title="<?= lang('Crm.newCall') ?>" class="btn btn-light pl-3" href="<?= base_url('crm/activities/calls/new') ?>?<?=$getIdentifier[$type]?>=<?=$id?>"><i class='fas fa-phone' style='font-size:12px'></i></a>
          <a type="button" title="<?= lang('Crm.newMeeting') ?>" class="btn btn-light pl-3" href="<?= base_url('crm/activities/meetings/new') ?>?<?=$getIdentifier[$type]?>=<?=$id?>"><i class='far fa-calendar-alt' style='font-size:12px'></i></a>
        </div>

        <div class="card w-100 rounded-0 border-0 ">
          <div class="card-body p-1 table-responsive-md">

            <table class="table table-sm table-hover ">
              <thead class="thead-light">
                <tr>

                  <th class="small text-muted text-secondary"><?= lang('Crm.title') ?></th>
                  <th class="small text-muted text-secondary"><?= lang('Crm.startDateTime') ?></th>
                  <th class="small text-muted text-secondary"><?= lang('Crm.user') ?></th>

                </tr>
              </thead>
              <tbody>

                <?php
                if (is_array($activitiesList)) {

                  foreach ($activitiesList as $al) {


                    echo '<tr>';

                    if ($al->activity_type == 'c') {

                      echo '
                      <td><i class="fas fa-phone" style="font-size:12px"></i> <a class="font-weight-normal" href="' . base_url('crm/activities/call/') . '' . $al->id . '">' . $al->title . '</a></td>
                      ';
                    } elseif ($al->activity_type == 'm') {

                      echo '
                      <td><i class="far fa-calendar-alt" style="font-size:12px"></i> <a class="font-weight-normal" href="' . base_url('crm/activities/meeting/') . '' . $al->id . '">' . $al->title . '</a></td>
                      ';
                    } elseif ($al->activity_type == 'e') {

                      echo '
                      <td><i class="far fa-envelope" style="font-size:12px"></i> <a class="font-weight-normal" href="' . base_url('crm/activities/email/') . '' . $al->id . '">' . $al->title . '</a></td>
                      ';
                    }

                    echo '
                    <td>' . showDateAndTime($al->start_date) . '</td>
                    <td><a href="' . base_url('crm/user') . '/' . $al->user_id . '">' . $al->user_full_name . '</a></td>
                    ';
                    echo '<tr>';
                  }
                }

                ?>

              </tbody>
            </table>

            <div class="m-2"><?= $pager_links ?></div>

          </div>

        </div>

      </div>

    </div>
  </div>