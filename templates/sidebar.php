<nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">

          <?php 


            $uri = $_SERVER['REQUEST_URI']; 
            $uriAr = explode("/", $uri);
            $page = end($uriAr);
            $uname= $_SESSION['user'];

            // if($uname == 'admin@test.com'){
              if($uname == 'admin@test.com'){

          ?>


          <li class="nav-item">
            <a class="nav-link <?php echo ($page == '' || $page == 'vendor-index.php') ? 'active' : ''; ?>" href="vendor-index.php">
              <span data-feather="home"></span>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'customer_orders.php') ? 'active' : ''; ?>" href="customer_orders.php">
              <span data-feather="shopping-cart"></span>
              Overall Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'customer_pre_orders.php') ? 'active' : ''; ?>" href="customer_pre_orders.php">
              <span data-feather="shopping-cart"></span>
              Overall Pre-Orders
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'products.php') ? 'active' : ''; ?>" href="products.php">
              <span data-feather="shopping-cart"></span>
              Products
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'grade.php') ? 'active' : ''; ?>" href="grade.php">
              <span data-feather="shopping-cart"></span>
              grade
            </a>
          </li>
          
          
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'categories.php') ? 'active' : ''; ?>" href="categories.php">
              <span data-feather="shopping-cart"></span>
              Categories
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'customers.php') ? 'active' : ''; ?>" href="customers.php">
              <span data-feather="users"></span>
              Customers
            </a>
          </li>
        
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'messagelist.php') ? 'active' : ''; ?>" href="messagelist.php">
              <span data-feather="file"></span>
              Chat
            </a>
          </li>
          <?php }
          else {?>
            
            <li class="nav-item">
            <a class="nav-link <?php echo ($page == '' || $page == 'vendor-index.php') ? 'active' : ''; ?>" href="vendor-index.php">
              <span data-feather="home"></span>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'vendor_order.php') ? 'active' : ''; ?>" href="vendor_order.php">
              <span data-feather="file"></span>
              Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'vendor_pre_order.php') ? 'active' : ''; ?>" href="vendor_pre_order.php">
              <span data-feather="file"></span>
              Pre - Order
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'products.php') ? 'active' : ''; ?>" href="products.php">
              <span data-feather="shopping-cart"></span>
              Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'grade.php') ? 'active' : ''; ?>" href="grade.php">
              <span data-feather="shopping-cart"></span>
              grade
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'categories.php') ? 'active' : ''; ?>" href="categories.php">
              <span data-feather="shopping-cart"></span>
              Categories
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'customers.php') ? 'active' : ''; ?>" href="customers.php">
              <span data-feather="users"></span>
              Customers
            </a>
          </li>
        <?php } ?>
        </ul>

       
      </div>
    </nav>


    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Hello <?php echo $_SESSION['user']; ?></h1>
<!--         <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
          </button>
        </div> -->
      </div>