
<?php
    if(session()->getFlashdata('message')):

        echo '<div class="alert alert-info alert-dismissible m-1 mb-2">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          '.session()->getFlashdata('message').'
        </div>';

    elseif(session()->getFlashdata('error')):

        echo '<div class="alert alert-danger alert-dismissible m-1 mb-2">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          '.session()->getFlashdata('error').'
        </div>';

    endif;

?>
