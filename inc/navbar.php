 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-gray-dark navbar-dark">
   <!-- Left navbar links -->
   <ul class="navbar-nav">
     <li class="nav-item">
       <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
     </li>

     <li class="nav-item d-none d-sm-inline-block">
       <a href="https://spadaec.pnp.ac.id" class="nav-link" target="_blank" rel="noopener noreferrer">Spadaec</a>
     </li>
     <?php if (isset($_GET['page']) && $_GET['page'] == "mqtt") { ?>
       <li class="nav-item d-none d-sm-inline-block">
         <a class="nav-link" id="status" >Offline Broker</a>
       </li>
     <?php } ?>
     <li class="nav-item d-none d-sm-inline-block">
       <a href="/" class="nav-link" >HOME</a>
     </li>     
   </ul>
   <!-- Right navbar links -->
   <ul class="navbar-nav ml-auto">
     <!-- Navbar Search -->

     <li class="nav-item">
       <a class="nav-link" data-widget="fullscreen" href="#" role="button">
         <i class="fas fa-expand-arrows-alt"></i>
       </a>
     </li>
     <?php if (isset($_GET['page']) && $_GET['page'] == "mqtt") { ?>
     <li class="nav-item">
       <a class="nav-link"  href="../img/ABC.png" download="ABC.png" role="button">
       <i class="fas fa-download"></i>
       </a>
     </li>
     <?php } ?>
   </ul>
 </nav>
 <!-- /.navbar -->