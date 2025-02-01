<table class="table table-bordered table-sm">
  <tbody>

    <?php
    if (is_array($leadsList)) {
      foreach ($leadsList as $row) {
    ?>

        <tr>
          <td><a href="javascript:void(0)" onmousedown="window.location.href='<?= base_url('crm/lead/') . $row['id'] ?>'"> <?= $row['name'] ?> <?= $row['surname'] ?></a></td>
        </tr>

    <?php
      }
    }
    ?>

  </tbody>
</table>