<script>
  var $valid = [];

  var $frontendFolder = "frontend";
  var $BlogData;
  var $pagename;


  var token = 'e81f58444134a2a7e9570c2060ff64';
  var $DATA;
  fetch('/cms/api/collections/get/Page?token='+token)
  .then(res => res.json())
  .then(res => {
        $DATA = res;
        LoadAllPages(res);
  }); 

  var $LoadedPages = 0;
  function LoadAllPages(){
    if($DATA["entries"].length > $LoadedPages){
      $BlogData = $DATA["entries"][$LoadedPages]["CustomFields"];
      $pagename = $DATA["entries"][$LoadedPages]["Pagename"];
      LoadComponentsRow($BlogData);
      console.log("Generated Page:"+$LoadedPages);
      $LoadedPages++;
    }else{
      console.log("All Pages Generated");
    }
  }

  //Load Ajax
  var $LoadedComponents = 0;
  function LoadComponentsRow($BlogData){
    if($BlogData.length > $LoadedComponents){
      $valid[$LoadedComponents] = false;
      $customField = $BlogData[$LoadedComponents]["field"]["name"];

      LoadComponents($LoadedComponents, $BlogData, $customField);
      $LoadedComponents++;
    }else{
      if(validationCheck($BlogData.length)){
        generateFilesAndFolder($pagename, $frontendFolder);
      }
    }
  }


  // Load Components
  function LoadComponents($fieldID, $BlogData, $customField){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("input").innerHTML = this.responseText;
        buildTemplate($BlogData[$fieldID]["value"]);
        if(this.responseText){
          $valid[$fieldID] = true;
          LoadComponentsRow($BlogData);
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
        LoadAllPages();
      }
    };
    $innerHTML = document.getElementById("output").innerHTML
    xhttp.open("POST", "generator/GeneratePage.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("pagename="+pagename+"&frontendfolder="+frontendFolder+"&innerhtml="+$innerHTML); 
  }
</script>

<!-- create file -->

<script id="input" type="text/x-handlebars-template"> 
</script>

<hr/>

<div id="output">
</div>