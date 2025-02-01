</head>

<body class="bg-light text-dark">


    <?= view('default/crm/navbar.php') ?>



    <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">
        <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2 ">
            <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
            <li class="breadcrumb-item active"><?= $user['name'] ?> <?= $user['surname'] ?></li>
        </ul>


        <?= view('default/crm/crm_message_box.php') ?>


        <div class="row pl-3 pr-3 pb-3">

            <?php if (userAdmin()): ?>

                <div class="col-sm-12">
                    <div class="pt-0 pb-0 float-right ">
                        <a type="button" href="<?= base_url('admin/edit-user/') . $user['id'] ?>" class="btn btn-info btn-sm"><?= lang('Crm.edit') ?> <i class="fas fa-pen" style="font-size:12px"></i></a>
                    </div>
                </div>

            <?php else: ?>


                <div class="col-sm-12">
                    <div class="pt-0 pb-0 float-right ">
                        <a type="button" href="<?= base_url('crm/edit-user/') ?>" class="btn btn-info btn-sm"><?= lang('Crm.edit') ?> <i class="fas fa-pen" style="font-size:12px"></i></a>
                    </div>
                </div>

            <?php endif; ?>


            <div class="col-sm-3">


                <div class="border-bottom border-light">
                    <small class="font-weight-bold "><?= lang('Crm.name') ?></small>
                    <p><?= $user['name'] ?> <?= $user['surname'] ?></p>
                </div>



            </div>



            <div class="col-sm-3 ">


                <div class="border-bottom border-light">
                    <small class="font-weight-bold "><?= lang('Crm.position') ?></small>
                    <p> <?= $user['position'] ?></p>
                </div>



            </div>



            <div class="col-sm-3 ">

                <div class="border-bottom border-light">
                    <small class="font-weight-bold "><?= lang('Crm.phone') ?></small>
                    <p><a href="tel:<?= $user['phone'] ?>"><?= $user['phone'] ?></a></p>
                </div>




            </div>


            <div class="col-sm-3 ">

                <div class="border-bottom border-light">
                    <small class="font-weight-bold "><?= lang('Crm.email') ?></small>
                    <p><a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a></p>
                </div>

            </div>


        </div>

    </div>