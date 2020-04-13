<?php
    $pagename = $_POST["pagename"];
    $pagename = str_replace(' ', '-', $pagename);
    $frontendFolder = $_POST["frontendfolder"];
    $innerHtml = $_POST["innerhtml"];


    // Generate Folder and Open File
    if(!is_dir($_SERVER["DOCUMENT_ROOT"]."/".$frontendFolder."/".$pagename)){
        mkdir($_SERVER["DOCUMENT_ROOT"]."/".$frontendFolder."/".$pagename); 
    }

    // Generate new Files and get Content
    $newFile = fopen($_SERVER["DOCUMENT_ROOT"]."/".$frontendFolder."/".$pagename."/index.php", "w");
    $content = file_get_contents("PageHead.php");
    
    // Generate File
    fwrite($newFile, "<!-- Generated with HollyCMS 0.0.2 -->");
    fwrite($newFile, $content);
    fwrite($newFile, $innerHtml);
?>
