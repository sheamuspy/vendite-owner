
<?php
    session_start();
    if(!isset($_SESSION['USER_ID'])){
        header("location:login.php");
    }
?>


<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="../css/custom.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
        <header>
          <nav>
    <div class="nav-wrapper">
      <a href="#!" class="brand-logo">Vendite</a>
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
        <li class="active"><a href="index.php">Inventory</a></li>
        <li><a href="add_products.php">Add Product</a></li>
        <li><a href="set_products.php">Set Pricing</a></li>
      </ul>
      <ul class="side-nav" id="mobile-demo">
        <li class="active"><a href="index.php">Inventory</a></li>
        <li><a href="add_products.php">Add Product</a></li>
        <li><a href="set_products.php">Set Pricing</a></li>
      </ul>
    </div>
  </nav>
        </header>
        <main>
        <h2>Inventory</h2>

        <table id="inventory-table">
            <thead>
                <tr>
                    <th>Barcode</th>
                    <th>Product</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </main>


        <footer class="page-footer">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">Vendite</h5>
                <p class="grey-text text-lighten-4">Keep track of your inventory</p>
              </div>
            </div>
          </div>
          <div align="right" class="footer-copyright">
            <div class="container">
                by Sheamus  Punch Yebisi
            </div>
          </div>
        </footer>


      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="../js/jquery-2.1.3.js"></script>
      <script type="text/javascript" src="../js/materialize.min.js"></script>
        <script type="text/javascript" src="../js/owner_invetory.js"></script>
    </body>
  </html>
