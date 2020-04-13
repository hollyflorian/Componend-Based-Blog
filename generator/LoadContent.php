<?php
// Load Components
$customField = $_GET["customfield"];
include $_SERVER["DOCUMENT_ROOT"].'/components/acf/'.$customField.'/'.$customField.'.html';
?>

