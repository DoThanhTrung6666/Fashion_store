<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Quản trị Fashion-Store</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('dist/css/SizeColorStatus.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
        type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->

    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="{{ asset('plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dist/css/SizeColorStatus.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dist/css/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body class="skin-blue">
    <div class="wrapper">

        <header class="main-header">
            <a href="index.html" class="logo"><b>Trang quản trị viên</b></a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    <ul class="menu">
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="dist/img/user2-160x160.jpg" class="img-circle"
                                                    alt="User Image" />
                                            </div>
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left"> <img
                                                src="dist/img/user3-128x128.jpg" class="img-circle" alt="user image" />
                                        </div>
                                        <h4>
                                            AdminLTE Design Team
                                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="user image" />
                                        </div>
                                        <h4>
                                            Developers
                                            <small><i class="fa fa-clock-o"></i> Today</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="user image" />
                                        </div>
                                        <h4>
                                            Sales Department
                                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="user image" />
                                        </div>
                                        <h4>
                                            Reviewers
                                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                    </li>
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning"></span>
                        </a>
                    </li>
                    <!-- Tasks: style can be found in dropdown.less -->
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger"></span>
                        </a>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <style>
                        .user-image {
                            width: 100px; /* Chiều rộng của ảnh */
                            height: 100px; /* Chiều cao của ảnh */
                            border-radius: 50%; /* Tạo hình tròn */
                            object-fit: cover; /* Đảm bảo ảnh phủ kín khung mà không bị biến dạng */
                        }

                    </style>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{Storage::url(Auth::user()->avatar)}}" class="user-image" alt="User Image" />
                            <span class="hidden-xs">Hello - {{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{Storage::url(Auth::user()->avatar)}}" class="user-image" alt="User Image" />
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>{{Auth::user()->address}}</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="col-xs-12 text-center">
                                    <a href="{{route('home')}}">Trang mua hàng</a>
                                </div>
                                {{-- <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div> --}}
                                {{-- <div class="col-xs-6 text-center">
                                    <a href="#">Friends</a>
                                </div> --}}
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{route('logout')}}" class="btn btn-default btn-flat">Đăng xuất</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar">
                <div class="user-panel">

                    <div class="pull-left image">
                        <img src="{{Storage::url(Auth::user()->avatar)}}" class="user-image" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p>{{ Auth::user()->name }}</p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                {{-- <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search..." />
                        <span class="input-group-btn">
                            <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i
                                    class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form> --}}
                <ul class="sidebar-menu">
                    <li class="header">Tất cả chức năng</li>
                    <li class="treeview">
                        <a href="{{ route('admin.statistics.index') }}">
                            <i class="fa fa-chart-bar"></i>
                            <span>Bảng điều khiển</span>

                        </a>

                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="nav-icon fas fa-receipt"></i>
                            <span>Quản lý đơn hàng</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.orders.index') }}"><i class="fa fa-circle-o"></i>Danh
                                    sách</a></li>
                        </ul>
                    </li>
                    {{-- quản lí sản phẩm --}}
                    <li class="treeview">
                        <a href="{{ route('admin.products.index') }}">
                            <i class="fas fa-box"></i>
                            <span>Quản lí sản phẩm</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.products.index') }}"><i class="fa fa-circle-o"></i>Danh
                                    sách</a></li>
                            <li><a href="{{ route('admin.products.create') }}"><i class="fa fa-circle-o"></i>Thêm
                                </a></li>
                        </ul>
                    </li>
                    {{-- kết thúc quản lí sản phẩm  --}}
                    {{-- category --}}
                    <li class="treeview">
                        <a href="#">
                            <i class="nav-icon fas fa-tags"></i>
                            <span>Quản lí danh mục</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.categories.index') }}"><i class="fa fa-circle-o"></i>Danh
                                    sách</a></li>
                            <li><a href="{{ route('admin.categories.create') }}"><i
                                        class="fa fa-circle-o"></i>Thêm</a></li>
                        </ul>
                    </li>
                    {{-- kết thúc category  --}}

                    {{-- quản lí Size --}}
                    <li class="treeview">
                        <a href="{{ route('admin.sizes.index') }}">
                            <i class="fas fa-ruler-combined"></i>
                            <span>Quản lí kích cỡ</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.sizes.index') }}"><i class="fa fa-circle-o"></i>Danh

                                    sách</a></li>
                            <li><a href="{{ route('admin.sizes.create') }}"><i class="fa fa-circle-o"></i>Thêm </a>
                            </li>
                        </ul>
                    </li>
                    {{-- kết thúc quản lí Size  --}}
                    {{-- quản lí Color --}}
                    <li class="treeview">
                        <a href="{{ route('admin.colors.index') }}">
                            <i class="fas fa-palette"></i>
                            <span>Quản lí màu sắc</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.colors.index') }}"><i class="fa fa-circle-o"></i>Danh
                                    sách</a></li>
                            <li><a href="{{ route('admin.colors.create') }}"><i class="fa fa-circle-o"></i>Thêm </a>
                            </li>
                        </ul>
                    </li>
                    {{-- kết thúc quản lí Size  --}}

                    {{-- quản lí brand --}}
                    <li class="treeview">
                        <a href="{{ route('admin.brands.index') }}">
                            <i class="fas fa-tags"></i>
                            <span>Quản lí thương hiệu</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.brands.index') }}"><i class="fa fa-circle-o"></i>Danh
                                    sách</a></li>
                            <li><a href="{{ route('admin.brands.create') }}"><i class="fa fa-circle-o"></i>Thêm</a>
                            </li>
                        </ul>
                    </li>
                    {{-- kết thúc quản lí brand  --}}
                    {{-- quản lí  sale --}}
                    <li class="treeview">
                        <a href="{{ route('admin.sales.index') }}">
                            <i class="fas fa-percent"></i>
                            <span>Quản lí Sale(%)</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.sales.index') }}"><i class="fa fa-circle-o"></i>Danh
                                    sách</a></li>
                            <li><a href="{{ route('admin.sales.create') }}"><i class="fa fa-circle-o"></i>Thêm</a>
                            </li>
                        </ul>
                    </li>
                    {{-- kết thúc quản lí  sale  --}}
                    {{-- quản lí flash sale --}}
                    <li class="treeview">
                        <a href="{{ route('admin.sales.index') }}">
                            <i class="fas fa-bolt"></i>
                            <span>Quản lí Flash-Sale</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.listFlashSale') }}"><i class="fa fa-circle-o"></i>Danh sách
                                    Flash-Sale</a></li>
                            <li><a href="{{ route('admin.createFlashSale') }}"><i class="fa fa-circle-o"></i>Tạo
                                    Flash-Sale</a></li>
                        </ul>
                    </li>
                    {{-- kết thúc quản lí flash sale  --}}

                    {{-- quản lí voucher --}}
                    <li class="treeview">
                        <a href="{{ route('admin.vouchers.index') }}">
                            <i class="fas fa-gift"></i>
                            <span>Quản lí Voucher</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.vouchers.index') }}"><i class="fa fa-circle-o"></i>Danh sách
                                    Voucher</a></li>
                            <li><a href="{{ route('admin.vouchers.create') }}"><i class="fa fa-circle-o"></i>Tạo
                                    Voucher</a></li>
                        </ul>
                    </li>
                    {{-- kết thúc quản lí voucher  --}}
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-group"></i>
                            <span>Quản lí người dùng</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.users.index') }}"><i class="fa fa-circle-o"></i>Danh
                                    sách</a></li>
                            <li><a href="{{ route('admin.users.create') }}"><i class="fa fa-circle-o"></i>Thêm
                                    mới</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-comment"></i>
                            <span>Quản lí bình luận</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.comment.index') }}"><i class="fa fa-circle-o"></i>Danh

                                    sách</a></li>
                        </ul>
                    </li>
                     {{-- quản lí banner --}}
                     <li class="treeview">
                        <a href="#">
                            <i class="nav-icon fas fa-image"></i>
                            <span>Quản lí ảnh banner</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.banners.index') }}"><i class="fa fa-circle-o"></i>Danh
                                    sách</a></li>
                            <li><a href="{{ route('admin.banners.create') }}"><i class="fa fa-circle-o"></i>Thêm </a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="nav-icon fas fa-image"></i>
                            <span>Đăng kí shipper</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="" class="fa fa-circle-o"></i>Danh
                                    sách</a></li>
                            <li><a href="{{route('admin.register.shipper')}}"><i class="fa fa-circle-o"></i>Thêm </a>
                            </li>
                        </ul>
                    </li>
                    {{-- kết thúc quản lí banner  --}}

                </ul>
            </section>
        </aside>


        {{-- nội dung ở đây --}}
        <div>
            @yield('content')
        </div>

        {{-- kết thúc nội dung --}}


        {{-- footer ở đây  --}}
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.0
            </div>
            <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All
            rights
            reserved.
        </footer>

    </div>

    <!-- jQuery 2.1.3 -->
    <script src="{{ asset('plugins/jQuery/jQuery-2.1.3.min.js') }}"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='{{ asset('plugins/fastclick/fastclick.min.js') }}'></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/app.min.js') }}" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparkline/jquery.sparkline.min.js') }}" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="{{ asset('plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="{{ asset('plugins/chartjs/Chart.min.js') }}" type="text/javascript"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dist/js/pages/dashboard2.js') }}" type="text/javascript"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}" type="text/javascript"></script>
</body>

</html>
