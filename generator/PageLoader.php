<?php
  $pageid = 1;
  $pagename = "Home";
  $frontendFolder = "frontend";
?>

<script>
var token = 'e81f58444134a2a7e9570c2060ff64';
fetch('/cms/api/collections/get/Page?token='+token)
  .then(res => res.json())
  .then(res => {
        $BlogData = res["entries"]["0"]["CustomFields"];
        for($fieldID in $BlogData){
          $customField = $BlogData[$fieldID]["field"]["name"];
          LoadComponents($fieldID, $BlogData, $customField);
        }
        console.log("finish");
  }); 

  // Load Components
  function LoadComponents($fieldID, $BlogData, $customField){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
      console.log($BlogData[$fieldID]["value"]);
      document.getElementById("input").innerHTML = this.responseText;
      buildTemplate($BlogData[$fieldID]["value"]);
      }
    };

    xhttp.open("GET", "generator/LoadContent.php?customfield="+$customField, true);
    xhttp.send();
  }

  function buildTemplate($BlogData){
    var source = document.getElementById("input").innerHTML;  
    var template = Handlebars.compile(source);

    var context = $BlogData;
    var html = template(context);
    var destination = document.getElementById("output");
    destination.innerHTML += html;
  }

</script>

<!-- create file -->

<script id="input" type="text/x-handlebars-template"> 
</script>

<hr/>

<div id="output">

</div>
