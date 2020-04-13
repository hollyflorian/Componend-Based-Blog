<script src="../libaries/handlebars-v4.7.3.js"></script>
<script>
  // Global Variables
  var $valid = [];
  var $frontendFolder = "frontend";
  var $BlogData;
  var $pagename;
  var token = 'e81f58444134a2a7e9570c2060ff64';
  var $DATA;

  // API call
  fetch('/cms/api/collections/get/Page?token='+token)
  .then(res => res.json())
  .then(res => {
        $DATA = res;
        LoadAllPages();
  }); 

  window.$LoadedPages = 0;
  function LoadAllPages(){
    // Clean up input and output File
    window.input = "";
    window.destination = "";

    // Set Pagename and Data for every Page
    if($DATA["entries"].length > window.$LoadedPages){
      $BlogData = $DATA["entries"][window.$LoadedPages]["CustomFields"];
      $pagename = $DATA["entries"][window.$LoadedPages]["Pagename"];
      LoadComponentsRow($BlogData);
      window.$LoadedPages++;

    }else{
      window.$LoadedPages = 0;
      console.log("All Pages Generated");
    }
  }

  //Load Compnents with Ajax
  window.$LoadedComponents = 0;
  function LoadComponentsRow($BlogData){
    if($BlogData.length > window.$LoadedComponents){
      $valid[window.$LoadedComponents] = false;
      $customField = $BlogData[window.$LoadedComponents]["field"]["name"];

      LoadComponents(window.$LoadedComponents, $BlogData, $customField);
      window.$LoadedComponents++;
    }else{
      if(validationCheck($BlogData.length)){
        generateFilesAndFolder($pagename, $frontendFolder);
        window.$LoadedComponents = 0;
      }
    }
  }


  // Load Components
  function LoadComponents($fieldID, $BlogData, $customField){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        window.input = this.responseText;
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
  
  // Simple Validation Check
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

  // Get data frm handlbars Tamplate and build to innerHTML
  function buildTemplate($BlogData){
    var source = window.input;  
    var template = Handlebars.compile(source);

    var context = $BlogData;
    window.destination = template(context);
  }

  // Generate Files and Folder with Ajax
  function generateFilesAndFolder(pagename, frontendFolder){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        window.destination += this.responseText;
        LoadAllPages();
      }
    };
    $innerHTML = window.destination;
    xhttp.open("POST", "generator/GeneratePage.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("pagename="+pagename+"&frontendfolder="+frontendFolder+"&innerhtml="+$innerHTML); 
  }
</script>