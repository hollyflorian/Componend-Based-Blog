<?php
    $pagename = $_GET["customfield"];
    $frontendFolder = $_GET["customfield"];
    
    mkdir($frontendFolder."/".$pagename); 
    $newFile = fopen($frontendFolder."/".$pagename."/index.php", "w");
    fwrite($newFile, "<a>Generated with Hollycms 0.0.1</a>");
?>
