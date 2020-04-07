<?php
    $pagename = "Home";
    $frontendFolder = "frontend";
    echo "../".$frontendFolder."/".$pagename;
    mkdir("../".$frontendFolder."/".$pagename ,0777 ,TRUE); 
    $newFile = fopen("../".$frontendFolder."/".$pagename."/index.php", "w");
    fwrite($newFile, "<a>Generated with Hollycms 0.0.1</a>");

    echo "Files Generated!";
?>
