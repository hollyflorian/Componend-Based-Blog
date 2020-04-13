<script src="http://localhost/libaries/handlebars-v4.7.3.js"></script>
<script>
  GenerateAllPages();
  function GenerateAllPages(){
    // Global Variables
    var token = 'e81f58444134a2a7e9570c2060ff64';
    window.$frontendFolder = "frontend";
    window.$LoadedPages = 0;
    window.$LoadedComponents = 0;
    window.$valid = [];

    // API call
    fetch('/cms/api/collections/get/Page?token='+token)
    .then(res => res.json())
    .then(res => {
          window.$DATA = res;
          LoadAllPages();
    }); 
  }

  function LoadAllPages(){
    // Clean up input and output File
    window.input = "";
    window.destination = "";

    // Set Pagename and Data for every Page
    if(window.$DATA["entries"].length > window.$LoadedPages){
      $BlogData = window.$DATA["entries"][window.$LoadedPages]["CustomFields"];
      window.$pagename = window.$DATA["entries"][window.$LoadedPages]["Pagename"];
      LoadComponentsRow($BlogData);
      window.$LoadedPages++;

    }else{
      window.$LoadedPages = 0;
      console.log("All Pages Generated");
    }
  }

  //Load Compnents with Ajax
  function LoadComponentsRow($BlogData){
    if($BlogData.length > window.$LoadedComponents){
      window.$valid[window.$LoadedComponents] = false;
      $customField = $BlogData[window.$LoadedComponents]["field"]["name"];

      LoadComponents(window.$LoadedComponents, $BlogData, $customField);
      window.$LoadedComponents++;
    }else{
      if(validationCheck($BlogData.length)){
        generateFilesAndFolder(window.$pagename, $frontendFolder);
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
          window.$valid[$fieldID] = true;
          LoadComponentsRow($BlogData);
        }
      } 
    };

    xhttp.open("GET", "http://localhost/generator/LoadContent.php?customfield="+$customField, true);
    xhttp.send();
  }
  
  // Simple Validation Check
  function validationCheck($DataLength){
    window.$validCheck = true;
    for($i in window.$valid){
      if(window.$valid[$i] !== true){
        window.$validCheck = false;
      }
    }

    if(window.$validCheck){
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
    window.destination += template(context);
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
    xhttp.open("POST", "http://localhost/generator/GeneratePage.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("pagename="+pagename+"&frontendfolder="+frontendFolder+"&innerhtml="+$innerHTML); 
  }
</script>