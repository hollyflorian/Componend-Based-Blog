<?php
    $pagename = $_GET["pagename"];
    $frontendFolder = $_GET["frontendfolder"];
    $innerHtml = $_GET["innerhtml"];

    mkdir("../".$frontendFolder."/".$pagename); 
    $newFile = fopen("../".$frontendFolder."/".$pagename."/index.php", "w");

    $content = file_get_contents("PageHead.php");
    // Generate File
    fwrite($newFile, "<!-- Generated with HollyCMS 0.0.1 -->");
    fwrite($newFile, $content);
    fwrite($newFile, $innerHtml);

    echo "Files Generated!";
?>
