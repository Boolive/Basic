<div class="widget widget_autolist">
<?php
    $list = $v['views']->arrays(\boolive\core\values\Rule::string());
    foreach ($list as $item){
        echo $item;
    }
?>
</div>