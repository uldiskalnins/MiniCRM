<table class="table table-bordered table-sm">
  <tbody>

    <?php
    if (is_array($opportunitiesList)) {
      foreach ($opportunitiesList as $row) {
    ?>

        <tr>
          <td><a href="javascript:void(0)" onmousedown="window.location.href='<?= base_url('crm/opportunity/') . $row['id'] ?>'"> <?= $row['title'] ?> </a></td>
        </tr>

    <?php
      }
    }
    ?>

  </tbody>
</table>