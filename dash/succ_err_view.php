<?php 
if(!empty($main_err)) {
    echo '<div class="alert alert-danger"><em>' . $main_err .'</em></div>';
}

if(!empty($main_succ)) {
    echo '<div class="alert alert-success"><em>' . $main_succ .'</em></div>';
}
?>