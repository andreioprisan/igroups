<?php
$_SERVER['PATH_INFO'] = '/hook/outbound/cron';
chdir(dirname(dirname(dirname(__FILE__))));
require('index.php');
