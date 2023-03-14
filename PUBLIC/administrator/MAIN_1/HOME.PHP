<?php include_once '../../../private/initialize.php'; ?>

<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link rel="stylesheet" type="text/css" href="<?php echo url_for("/css/main.css"); ?>">
  <script src ="<?php echo url_for("/js/jquery-3.3.1.min.js"); ?>"></script>
  <script src="<?php echo url_for("/js/main.js"); ?>"></script>
  
</head>
<body>
  <div class="container">
    <div class="top-container">
      <img style = "width:100%" class ="full-img" src="<?php echo url_for("/img/logo_f.jpg") ?>">

    <div class="header" id="myHeader">
      <div class="top-nav">
        <ul class="main_menu">
          <li><a href="<?php echo url_for("/administrator/login.php") ?>">Register/Log_In</a></li>
          <li><a href="#event">event</a></li>
          <li><a href="#counter">achivment</a></li>
          <li><a href="#contact">About Marinig</a></li>
          <li class="active"><a href="#header">Home</a></li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="column" style="background-color:#aaa;">
        <h1 id = "slide">Mission</h1>
        <p id = "slide-panel">An institution of higher learning developing globally-competitive
          and value-laden professionals and leaders instrumental to community development 
          and nation building.</p>
      </div>
       <div class="column" style="background-color:#bbb;">
          <h1 id = "slide1">Vision</h1>
          <p id = "slide-panel1">An institution of higher learning committed to equip individuals
            with knowledge, skills and values that will enable them to achieve their professional
            goals and provide leadership and service for national development.</p>
        </div>
    </div>
     
    <div class = "contenting">
      <div>
        <h1>History</h1>
        <p>Barangay Marinig located at Laguna Province. The next rising shining star in Municipality of Laguna.<br>
           Show the visitor warm welcome and other citizen to come in our barangay.<br>
          Thank You...</p>
      </div>
    </div>

    <div class="row-nav">
      <h1 class="margin-bottom">Gallery</h1>
      <div class="column-nav" style="background-color:#aaa;">
        <h2 id = "c-nav">Festival</h2>
        <img style = "width:100%" class ="full-img" src="<?php echo url_for("/img/header2.jpg") ?>">
    </div>
    
    <div class="column-nav" style="background-color:#bbb;">
      <h2 id = "c-nav">league</h2>
        <img style = "width:85%" class ="full-img" src="<?php echo url_for("/img/league1.jpg") ?>">
     </div>
     
    <div class="column-nav" style="background-color:#ccc;">
      <h2 id = "c-nav">Sinakulo</h2>
       <img style = "width:100%" class ="full-img" src="<?php echo url_for("/img/header3.jpg") ?>">
    </div>

  </div>
   <div class = "footer">
       <div class = "content-nav">
        <br><br>
          <p>Copyright 2018, Group Project in Web 3...</p>
         
          <p>Copyright 2018, Group Project in Web 3...</p>
       </div>
    </div>
  
    



  <script>
      window.onscroll = function() {myFunction()};

      var header = document.getElementById("myHeader");
      var sticky = header.offsetTop;

      function myFunction() {
        if (window.pageYOffset >= sticky) {
           header.classList.add("sticky");
        } else {
            header.classList.remove("sticky");
        }
      }

</script>

</body>
</html>