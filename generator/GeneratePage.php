<?php
    $pagename = $_POST["pagename"];
    $frontendFolder = $_POST["frontendfolder"];
    $innerHtml = $_POST["innerhtml"];

        mkdir("../".$frontendFolder."/".$pagename); 
        $newFile = fopen("../".$frontendFolder."/".$pagename."/index.php", "w");

        $content = file_get_contents("PageHead.php");
        // Generate File
        fwrite($newFile, "<!-- Generated with HollyCMS 0.0.2 -->");
        fwrite($newFile, $content);
        fwrite($newFile, $innerHtml);
?>
