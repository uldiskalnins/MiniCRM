<table class="table table-bordered table-sm">
    <tbody>

        <?php
        if (is_array($usersData)) {
            foreach ($usersData as $row) {
        ?>

                <tr>
                    <td><a href="javascript:void(0)" onmousedown="updateAssignedUser(<?= $row['id'] ?>,'<?= $row['name'] ?> <?= $row['surname'] ?>')"><?= $row['name'] ?> <?= $row['surname'] ?></a></td>
                </tr>

        <?php
            }
        }
        ?>

    </tbody>
</table>