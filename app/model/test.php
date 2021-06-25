<?php
    $datetime = new DateTime('now');
    $week = $datetime->format('W');
    echo $week;
?>