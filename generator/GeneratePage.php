<?php
    $pagename = $_GET["pagename"];
    $frontendFolder = $_GET["frontendfolder"];
    $innerHtml = $_GET["innerhtml"];
    echo "../".$frontendFolder."/".$pagename;
    mkdir("../".$frontendFolder."/".$pagename ,0777 ,TRUE); 
    $newFile = fopen("../".$frontendFolder."/".$pagename."/index.php", "w");
    fwrite($newFile, $innerHtml);

    echo "Files Generated!";
?>
