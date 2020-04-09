<?php
    $pagename = $_GET["pagename"];
    $frontendFolder = $_GET["frontendfolder"];
    $innerHtml = $_GET["innerhtml"];
    echo "../".$frontendFolder."/".$pagename;
    mkdir("../".$frontendFolder."/".$pagename ,0777 ,TRUE); 
    $newFile = fopen("../".$frontendFolder."/".$pagename."/index.php", "w");

    $test = file_get_contents("PageHead.php");
    // Generate File
    fwrite($newFile, "<!-- Generated with HollyCMS 0.0.1 -->");
    fwrite($newFile, $test);
    fwrite($newFile, $innerHtml);

    echo "Files Generated!";
?>
