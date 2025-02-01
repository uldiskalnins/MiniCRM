<?php

    if (is_array($contactPersonsList)) {

        echo '<table class="table table-borderless table-sm">
                <tbody>';

        foreach ($contactPersonsList as $row) {

            echo '<tr>
                <td>' . '<a href="javascript:void(0)" onmousedown="selectPerson(' . $row['id'] . ",'" . $row['name'] . ' ' . $row['surname'] . "'" . ')">' . $row['name'] . ' ' . $row['surname'] . '</a>' . '</td>
                </tr>';
        }
        echo '</tbody></table>';
    }
