<?php

$color = $_GET['color'];

if(!$color){ $color = "pink"; }

$output = shell_exec("/opt/raspidash/scripts/blinkstick $color 25");