
  <table class="table table-bordered table-sm">
    <tbody>

    <?php 
        if(is_array($parentsList)){
            foreach ($parentsList as $row){ 
    ?>

                <tr>
                <td><a href="javascript:void(0)" onmousedown="updateParent(<?= $row['id'] ?>,'<?= htmlspecialchars($row['name'])?> <?= htmlspecialchars($row['surname'])?>','<?= $row['company_id']?>','<?= htmlspecialchars($row['title'])?>')"><?= htmlspecialchars($row['name'])?> <?= htmlspecialchars($row['surname'])?></a></td>
                </tr>

    <?php
            }
        }
    ?>

    </tbody>
  </table>