<!doctype html>
<html lang="en">

    
<!-- Mirrored from themesdesign.in/upzet/layouts/layouts-horizontal.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 07 Jun 2022 06:42:22 GMT -->
<head>

        <meta charset="utf-8" />
        <title>PAP-Homepage</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="PAP By Green Nusa" name="description" />
        <meta content="Themesdesign" name="Green Nusa Computindo" />
        <!-- App favicon -->
        <!-- <link rel="shortcut icon" href="assets/images/favicon.ico"> -->

        <!-- Bootstrap Css -->
        <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
        
        <!-- Bootstrap Css -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
        
        <!-- jvectormap -->
        <link href="{{asset('assets/libs/jqvmap/jqvmap.min.css')}}" rel="stylesheet" />

        <!-- jvectormap -->
        <link href="{{asset('assets/libs/jqvmap/jqvmap.min.css')}}" rel="stylesheet" />

        <!-- DataTables -->
        <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

        
        <!-- Icons Css -->
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <style type="text/css">
            #page-topbar{
                background-color: rgba(99,102,241,0.77);
            }
            .labels{
                color: white;
            }
            .login{
                color: white;
                font-weight: bold;
                font-size: 20px;
            }
        </style>

    </head>

    <body data-topbar="light" data-layout="horizontal">

        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box text-center">
                            <a href="index-2.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <!-- <h2>PAP</h2> -->
                                </span>
                                <span class="logo-lg">
                                    <!-- <h2>PAP</h2> -->
                                </span>
                            </a>

                            <a href="index-2.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <!-- <h2>PAP</h2> -->
                                </span>
                                <span class="logo-lg">
                                    <!-- <h2>PAP</h2> -->
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item" data-bs-toggle="collapse"
                            data-bs-target="#topnav-menu-content">
                            <i class="ri-menu-2-line align-middle"></i>
                        </button>

                        <!-- App Search-->
                        <form class="app-search d-none d-lg-block">
                            <div class="position-relative">
                                <h1 class="labels">Pajak Air Permukaan (PAP)</h1>
                            </div>
                        </form>

                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-inline-block d-lg-none ms-2">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-search-line"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">

                                <form class="p-3">
                                    <div class="mb-3 m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ...">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="ri-search-line"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>                     
                        
                        <div class="dropdown d-inline-block user-dropdown">
                            <a href="login"><span class="login"><i class="ri-user-line align-middle me-1"></i>Login</span></a>
                            
                        </div>
                    </div>
                </div>
            </header>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">PAP</a></li>
                                            <li class="breadcrumb-item active">Home Page</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        
                        <!-- end row -->

                        <div class="row">
                            <div class="col-xl-5">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h3 class="">Wajib Pajak</h3>
                                            </div>
                                          
                                        </div>

                                        <div>
                                             <canvas id="kotaChart" height=220></canvas>
                                        </div>
                                    </div>
                                    <!-- end card-body -->

                                    <div class="card-body border-top">
                                        <div class="text-muted text-center">
                                            
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <div class="col-xl-7">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h3 class="">Total Realisasi UPT.PPRD Provinsi</h3>
                                            </div>
                                          
                                        </div>

                                        <div>
                                             <canvas id="myChart"></canvas>
                                        </div>
                                    </div>
                                    <!-- end card-body -->

                                    <div class="card-body border-top">
                                        <div class="text-muted text-center">
                                            
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>

                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h3 class="">Target dan Realisasi UPT.PPRD Wilayah</h3>
                                            </div>
                                          
                                        </div>

                                        <div>
                                             <canvas id="horizontalBars" height=70></canvas>
                                        </div>
                                    </div>
                                    <!-- end card-body -->

                                    <div class="card-body border-top">
                                        <div class="text-muted text-center">
                                            
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                           
                            <!-- end col -->

                        </div>
                        <!-- end row -->
                    </div>

                </div>
                <!-- End Page-content -->

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Green Nusa.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="https://1.envato.market/themesdesign" target="_blank">Themesdesign</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>

            </div>
            <!-- end main content-->

        </div>
       
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="https://pap.aplikasipos.id/assets/libs/jquery/jquery.min.js"></script>
        <script src="https://pap.aplikasipos.id/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="https://pap.aplikasipos.id/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="https://pap.aplikasipos.id/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="https://pap.aplikasipos.id/assets/libs/node-waves/waves.min.js"></script>

        <!-- apexcharts js -->
        <script src="https://pap.aplikasipos.id/assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Chart JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- <script type="text/javascript" src="https://cdnjs.com/libraries/Chart.js"></script> -->
        <!-- <script src="assets/js/app.js"></script> -->

        <script type="text/javascript">
            const target = @json($values);
            const realisasi = @json($chartData);
            const testArr = new Array(12).fill(0);
            realisasi.forEach((realization)=>{
            testArr[new Date(realization.date).getMonth()] = realization.sum;
            console.log(new Date(realization.date), realization.date)
            })
            console.log(testArr);
            const ctx = document.getElementById("myChart").getContext("2d"); 
            const dataset = {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [
                        { label: "Target", data: target, backgroundColor: "#3d8ef8" },
                        { label: "Realisasi", data: testArr, backgroundColor: "#11c46e" },
                    ],
                }       
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: dataset,
                options: {
                    interaction: {
                        mode: "index",
                    },
                     tooltips: {
                        callbacks: {
                            data (t, d) {
                                const xLabel = d.datasets[t.datasetIndex].label;
                                const yLabel = t.yLabel >= 1000 ? 'Rp.' + t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') : '$' + t.yLabel;
                                return xLabel + ": " + yLabel;
                            }
                        }
                    },
                    scales: {
                        yAxes: [
                          {
                            ticks: {
                            beginAtZero: true,
                            callback: (label, index, labels) => {
                                    return 'Rp.' + label.toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            }
                          }
                        }
                      ]
                    },
                },
            });
        </script>

        <script type="text/javascript">
            const kotaCanvas = $("#kotaChart");
            let chartTargets = @json($chartTargets);
            let chartLabel = @json($chartLabels);
            const kotaData = {
                labels: chartLabel,
                datasets: [
                {
                    data: chartTargets,
                    backgroundColor: [
                    "#FF6384",
                    "#63FF84",
                    "#84FF63",
                    "#8463FF",
                    "#6384FF",
                    "#FF63C1",
                    "#D663FF",
                    "#63C7FF",
                    "#63ECFF"
                    ]
                }]
            };

            const pieChart = new Chart(kotaCanvas, {
                type: 'pie',
                data: kotaData,
                options: {
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var allData = data.datasets[tooltipItem.datasetIndex].data;
                                var tooltipLabel = data.labels[tooltipItem.index];
                                var tooltipData = allData[tooltipItem.index];
                                var total = 0;
                                for (var i in allData) {
                                    total += allData[i];
                                }
                                var tooltipPercentage = Math.round((tooltipData / total) * 100);
                                return tooltipLabel + ': ' + tooltipData + ' (' + tooltipPercentage + '%)';
                            }
                        }
                    }
                }
            });
        </script>

        <script type="text/javascript">
            var MeSeContext = document.getElementById("horizontalBars").getContext("2d");
            let chartLabels = @json($chartLabels);
            let chartTarget = @json($chartTargets);
            let chartRealisasi = @json($chartRealisasis);
            const data = {
                labels: chartLabels,
              datasets: [
              {label: "Target", data: chartTarget, backgroundColor: "#3d8ef8"},
              {label: "realisasi", data: chartRealisasi, backgroundColor: "#11c46e"},  
            ]
        };

        var MeSeChart = new Chart(MeSeContext, {
            type: 'bar',
            data: data,
            options: {
                    indexAxis: 'y',
                    interaction: {
                        mode: "index",
                    },
                        tooltips: {
                        callbacks: {
                            data: function (t, d) {
                                const xLabel = d.datasets[t.datasetIndex].label;
                                const yLabel = t.yLabel >= 1000 ? 'Rp.' + t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') : '$' + t.yLabel;
                                return xLabel + ': ' + yLabel;
                            }
                        }
                    },
                    scales: {
                        yAxes: [
                          {
                            ticks: {
                            beginAtZero: true,
                            callback: (label, index, labels) => {
                                    return 'Rp.' + label.toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            }
                          }
                        }
                      ]
                    },
                },
        });
    </script>


    </body>

<!-- Mirrored from themesdesign.in/upzet/layouts/layouts-horizontal.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 07 Jun 2022 06:42:22 GMT -->
</html>
