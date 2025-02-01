<table class="table table-bordered table-sm mb-0 ">
    <tbody class="">

        <?php
        if (is_array($accountsList)) {
            foreach ($accountsList as $row) {
        ?>

                <tr>
                    <td><a href="javascript:void(0)" onmousedown="window.location.href='<?= base_url('crm/company')  ?>/<?= $row['id'] ?>'"> <?= $row['title'] ?></a></td>
                </tr>

        <?php
            }
        }

        ?>
    </tbody>
</table>