<table class="table table-bordered table-sm">
    <tbody>

        <?php
        if (is_array($accountsList)) {
            foreach ($accountsList as $row) {
        ?>

                <tr>
                    <td><a href="javascript:void(0)" onmousedown="updateConnectedCompany(<?= $row['id'] ?>,'<?= htmlspecialchars($row['title']) ?>')"><?= $row['title'] ?></a></td>
                </tr>

        <?php
            }
        }
        ?>

    </tbody>
</table>