<?php
  $pageid = 1;
  $pagename = "Home";
  $frontendFolder = "frontend";
?>

<script>
var $valid = [];

var token = 'e81f58444134a2a7e9570c2060ff64';
fetch('/cms/api/collections/get/Page?token='+token)
  .then(res => res.json())
  .then(res => {
        $BlogData = res["entries"]["0"]["CustomFields"];
        for($fieldID in $BlogData){
          $valid[$fieldID] = false;
          $customField = $BlogData[$fieldID]["field"]["name"];
          LoadComponents($fieldID, $BlogData, $customField);
        }
  }); 

  // Load Components
  function LoadComponents($fieldID, $BlogData, $customField){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log($BlogData[$fieldID]["value"]);
        document.getElementById("input").innerHTML = this.responseText;
        buildTemplate($BlogData[$fieldID]["value"]);
        if(this.responseText){
          $valid[$fieldID] = true;
          if(validationCheck($BlogData.length)){
            generateFilesAndFolder("<?php echo $pagename ?>","<?php $frontendFolder ?>");
          }
        }
      } 
    };

    xhttp.open("GET", "generator/LoadContent.php?customfield="+$customField, true);
    xhttp.send();
  }
  
  function validationCheck($DataLength){
    $validCheck = true;

    for($i in $valid){
      if($valid[$i] !== true){
        $validCheck = false;
      }
    }

    if($validCheck){
      return true;
    }else{
      return false;
    }
  }

  function buildTemplate($BlogData){
    var source = document.getElementById("input").innerHTML;  
    var template = Handlebars.compile(source);

    var context = $BlogData;
    var html = template(context);
    var destination = document.getElementById("output");
    destination.innerHTML += html;
  }

  function generateFilesAndFolder(pagename, frontendFolder){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("output").innerHTML += this.responseText;
      }
    };

    xhttp.open("GET", "generator/GeneratePage.php?pagename="+pagename+"&frontendfolder="+frontendFolder, true);
    xhttp.send();
  }

</script>

<!-- create file -->

<script id="input" type="text/x-handlebars-template"> 
</script>

<hr/>

<div id="output">

</div>
