<h2>Error</h2>
<div class="alert alert-danger">
    <?php
        $msg = CHtml::encode($message);
        $msg .= "<br>" . CHtml::encode($trace);

        echo $msg;
    ?>
</div>
