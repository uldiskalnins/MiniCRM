<table class="table table-bordered table-sm">
    <tbody>

        <?php
        if (is_array($parentsList)) {
            foreach ($parentsList as $row) {
        ?>

                <tr>
                    <td><a href="javascript:void(0)" onmousedown="updateParent(<?= $row['id'] ?>,'<?= htmlspecialchars($row['title']) ?>')"><?= $row['title'] ?></a></td>
                </tr>

        <?php
            }
        }
        ?>
    </tbody>
</table>