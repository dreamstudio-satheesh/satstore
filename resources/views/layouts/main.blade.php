<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="POS - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Dreams Pos admin template</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ url ('') }}/assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ url ('') }}/assets/css/bootstrap.min.css">
		
		<!-- animation CSS -->
        <link rel="stylesheet" href="{{ url ('') }}/assets/css/animate.css">

		<!-- Select2 CSS -->
		<link rel="stylesheet" href="{{ url ('') }}/assets/plugins/select2/css/select2.min.css">

		<!-- Datatable CSS -->
		<link rel="stylesheet" href="{{ url ('') }}/assets/css/dataTables.bootstrap4.min.css">
		
        <!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{ url ('') }}/assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="{{ url ('') }}/assets/plugins/fontawesome/css/all.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="{{ url ('') }}/assets/css/style.css">

		@livewireStyles
		
    </head>
	<body>
	
		<div id="global-loader" >
			<div class="whirly-loader"> </div>
		</div>


		<!-- Main Wrapper -->
        <div class="main-wrapper">
			
			<!-- Header -->
			<div class="header">
			
				<!-- Logo -->
                 <div class="header-left active">
                    <a href="{{ url('/home') }}" class="logo">
						<img src="{{ url('') }}/assets/img/logo.png"  alt="">
					</a>
					<a href="index.html" class="logo-small">
						<img src="{{ url('') }}/assets/img/logo-small.png"  alt="">
					</a>
					<a id="toggle_btn" href="javascript:void(0);">
					</a>
                </div>
				<!-- /Logo -->
				
				<a id="mobile_btn" class="mobile_btn" href="#sidebar">
					<span class="bar-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
				</a>
				
				<!-- Header Menu -->
				<ul class="nav user-menu">
				
				
					

					<li class="nav-item dropdown has-arrow main-drop">
						<a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                            <span class="user-img"><img src="{{ url('') }}/assets/img/profiles/avator1.jpg" alt="">
                            <span class="status online"></span></span>
						</a>
						<div class="dropdown-menu menu-drop-user">
							<div class="profilename">
								<div class="profileset">
									<span class="user-img"><img src="{{ url('') }}/assets/img/profiles/avator1.jpg" alt="">
									<span class="status online"></span></span>
									<div class="profilesets">
										<h6>Arun Kumar</h6>
										<h5>Admin</h5>
									</div>
								</div>
								<hr class="m-0">
								<a class="dropdown-item" href="profile.html"> <i class="me-2"  data-feather="user"></i> My Profile</a>
								<a class="dropdown-item" href="generalsettings.html"><i class="me-2" data-feather="settings"></i>Settings</a>
								<hr class="m-0">
								<a class="dropdown-item logout pb-0" href="signin.html"><img src="{{ url('') }}/assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
							</div>
						</div>
					</li>
				</ul>
				<!-- /Header Menu -->
				
				<!-- Mobile Menu -->
				<div class="dropdown mobile-user-menu">
					<a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="profile.html">My Profile</a>
						<a class="dropdown-item" href="settings.html">Settings</a>
						<a class="dropdown-item" href="index.html">Logout</a>
					</div>
				</div>
				<!-- /Mobile Menu -->
            </div>
			<!-- Header -->
			
           <!-- Sidebar -->
			<div class="sidebar" id="sidebar">
				<div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li >
								<a href="{{ url('/home') }}" class="active"><img src="{{ url('') }}/assets/img/icons/dashboard.svg" alt="img"><span> Dashboard</span> </a>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);"><img src="{{ url('') }}/assets/img/icons/product.svg" alt="img"><span> Product</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="{{ url('product') }}" >Product List</a></li>
									<li><a href="{{ url('product/create') }}" >Add Product</a></li>
									<li><a href="{{ url('category') }}" >Category List</a></li>
									<li><a href="{{ url('category/create') }}">Add Category</a></li>
									<li><a href="{{ url('brand') }}">Brand List</a></li>
									<li><a href="{{ url('brand/create') }}">Add Brand</a></li>
									<li><a href="#">Import Products</a></li>
									<li><a href="#">Print Barcode</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);"><img src="{{ url('') }}/assets/img/icons/sales1.svg" alt="img"><span> Sales</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="#">Sales List</a></li>
									<li><a href="pos">New Sales</a></li>
									<li><a href="#">Sales Return List</a></li>
									<li><a href="#">New Sales Return</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);"><img src="{{ url('') }}/assets/img/icons/purchase1.svg" alt="img"><span> Purchase</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="#">Purchase List</a></li>
									<li><a href="#">Add Purchase</a></li>
									<li><a href="#">Import Purchase</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);"><img src="{{ url('') }}/assets/img/icons/expense1.svg" alt="img"><span> Expense</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="#">Expense List</a></li>
									<li><a href="#">Add Expense</a></li>
									<li><a href="#">Expense Category</a></li>
								</ul>
							</li>
							
							<li class="submenu">
								<a href="javascript:void(0);"><img src="{{ url('') }}/assets/img/icons/quotation1.svg" alt="img"><span> Quotation</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="#">Quotation List</a></li>
									<li><a href="#">Add Quotation</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);"><img src="{{ url('') }}/assets/img/icons/transfer1.svg" alt="img"><span> Transfer</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="#">Transfer  List</a></li>
									<li><a href="#">Add Transfer </a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);"><img src="{{ url('') }}/assets/img/icons/return1.svg" alt="img"><span> Return</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="#">Sales Return List</a></li>
									<li><a href="#">Add Sales Return </a></li>
									<li><a href="#">Purchase Return List</a></li>
									<li><a href="#">Add Purchase Return </a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);"><img src="{{ url('') }}/assets/img/icons/users1.svg" alt="img"><span> People</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="{{ url('customer') }}">Customer List</a></li>
									<li><a href="{{ url('customer/create') }}">Add Customer  </a></li>
									<li><a href="{{ url('supplier') }}">Supplier List</a></li>
									<li><a href="{{ url('supplier/create') }}">Add Supplier </a></li>
									<li><a href="userlist">User List</a></li>
									<li><a href="adduser">Add User</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);"><img src="{{ url('') }}/assets/img/icons/places.svg" alt="img"><span> Places</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="newcountry">New Country</a></li>
									<li><a href="countrieslist">Countries list</a></li>
									<li><a href="newstate">New State </a></li>
									<li><a href="statelist">State list</a></li>
								</ul>
							</li>
							
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /Sidebar -->

			<div class="page-wrapper">
				@yield('content')
			</div>
        </div>
		<!-- /Main Wrapper -->
		 
		<!-- jQuery -->
        <script src="{{ url('') }}/assets/js/jquery-3.6.0.min.js"></script>


        <!-- Feather Icon JS -->
		<script src="{{ url('') }}/assets/js/feather.min.js"></script>

		<!-- Slimscroll JS -->
		<script src="{{ url('') }}/assets/js/jquery.slimscroll.min.js"></script>

		<!-- Datatable JS -->
		<script src="{{ url('') }}/assets/js/jquery.dataTables.min.js"></script>
		<script src="{{ url('') }}/assets/js/dataTables.bootstrap4.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="{{ url('') }}/assets/js/bootstrap.bundle.min.js"></script>

		<!-- Select2 JS -->
		<script src="{{ url('') }}/assets/plugins/select2/js/select2.min.js"></script>

		<!-- Sweetalert 2 -->
		<script src="{{ url('') }}/assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
		<script src="{{ url('') }}/assets/plugins/sweetalert/sweetalerts.min.js"></script>

		<!-- Custom JS -->
		<script src="{{ url('') }}/assets/js/script.js"></script>

		@livewireScripts
        
        @stack('script')
		
    </body>
</html>