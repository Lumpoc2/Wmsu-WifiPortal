<?php

require('routeros_api.class.php');

$API = new RouterosAPI();

if ($API->connect('192.168.1.40', 'admin', 'mark_123')) {
}
