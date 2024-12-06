@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    {{-- <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard</h4>
                @role('Admin|Operator')
                <div class="col-md-2">
                    <label for="kategori">Tahun</label>
                    <select class="form-control" name="year" id="date" onchange="doAction(this.value);">
                        <option value="">-- Pilih Tahun --</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{$year == request()->get("years") || $year == date('Y') && !request()->get("years") ?"selected":""}}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                @endrole
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="d-flex justify-content-around w-100">
        <div class="col-xl-3 col-sm-6 mx-1">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex text-muted">
                        <div class="flex-shrink-0  me-3 align-self-center">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-dark rounded-circle text-primary font-size-20" style="background-color: #5541D7 !important;">
                                    <i class="mdi mdi-clipboard-check"></i>
                                </div>
                            </div>
                        </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="mb-1">Target Kerja yang merujuk RPJMD</p>
                                <h5 class="mb-3">{{ $targetKerjaRpjmd }}</h5>
                            </div>
                    </div>                                        
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-sm-6 mx-1">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex text-muted">
                        <div class="flex-shrink-0  me-3 align-self-center">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-dark rounded-circle text-primary font-size-20" style="background-color: #5541D7 !important;">
                                    <i class="mdi mdi-exclamation-thick"></i>
                                </div>
                            </div>
                        </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="mb-1">Realisasi Kerja yang merujuk RPJMD</p>
                                <h5 class="mb-3">{{ $realisasiKerjaRpjmd }}</h5>
                            </div>
                    </div>
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->


        <div class="col-xl-3 col-sm-6 mx-1">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex text-muted">
                        <div class="flex-shrink-0  me-3 align-self-center">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-dark rounded-circle text-primary font-size-20" style="background-color: #5541D7 !important;">
                                    <i class="mdi mdi-exclamation-thick"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1">Target Kerja yang merujuk RPJMD</p>
                            <h5 class="mb-3">{{ number_format($targetKerjaNonRpjmd) }}</h5>
                        </div>
                    </div>
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>

        <div class="col-xl-3 col-sm-6 mx-1">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex text-muted">
                        <div class="flex-shrink-0  me-3 align-self-center">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-dark rounded-circle text-primary font-size-20" style="background-color: #5541D7 !important;">
                                    <i class="mdi mdi-exclamation-thick"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1">Realisasi Kerja yang merujuk RPJMD</p>
                            <h5 class="mb-3">{{ number_format($realisasiKerjaNonRpjmd) }}</h5>
                        </div>
                    </div>
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>

    </div> --}}
    <!-- end row -->
{{-- @push('scripts')
            <!-- apexcharts js -->
            <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

            <!-- jquery.vectormap map -->
            <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
            <script src="assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>
    
            <!-- chartJS cdn -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script src="assets/js/pages/dashboard.init.js"></script>
            <script>
                let chartLabel = @json($chartLabels);
                let chartData = @json($chartData);
                console.log(chartLabel, chartData);
                const lineData = {
                    labels: chartLabel,
                    datasets: [{
                        label: "Realisasi Per Bulan (Rp)",
                        backgroundColor: "rgb(255, 99, 132)",
                        borderColor: "rgb(255, 99, 132)",
                        data: chartData
                    }]
                }
                const config = {
                    type: "line",
                    data: lineData,
                    options: {
                        responsive: false,
                    }
                }

                const myChart = new Chart(
                    document.getElementById("lineChart"),
                    config
                );
                function doAction(val){
        //Forward browser to new url
        window.location.href = "{{ route('dashboard')}}" + "?years=" + val;
    }
            </script>
            <script>
            const target = @json($values);
            const realisasi = @json($chartData2);
            const testArr = new Array(12).fill(0);
            realisasi.forEach((realization)=>{
            testArr[new Date(realization.date).getMonth()] = realization.sum;
            console.log(new Date(realization.date), realization.date)
            })
            const ctx = $('#myChart');        
            const newChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [
                        { label: "Target", data: target, backgroundColor: "#3d8ef8" },
                        { label: "Realisasi", data: testArr, backgroundColor: "#11c46e" },
                    ],
                },
                options: {
                    interaction: {
                      mode: "index",  
                    },
                    tooltips: {
                      callbacks: {
                            data (t, d) {
                                const xLabel = d.datasets[t.datasetIndex].label;
                                const yLabel = t.yLabel >= 1000 ? 'Rp.' + t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') : '$' + t.yLabel;
                                console.log(yLabel);
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
            <script>
                const kotaCanvas = $("#kotaChart");
            let chartTargets = @json($chartTargets);
            let chartLabels = @json($chartLabels2);
            const kotaData = {
                labels: chartLabels,
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
            <script>
                  var MeSeContext = document.getElementById("horizontalBars").getContext("2d");
            let chartLabel2 = @json($chartLabels2);
            let chartTarget = @json($chartTargets);
            let chartRealisasi = @json($chartRealisasis);
            const data = {
                labels: chartLabel2,
              datasets: [
              {label: "Target", data: chartTarget, backgroundColor: "#3d8ef8"},
              {label: "realisasi", data: chartRealisasi, backgroundColor: "#11c46e"}]
        };

        var MeSeChart = new Chart(MeSeContext, {
            type: 'bar',
            data: data,
            options: {
                indexAxis: "y",
                interaction: {
                  mode: "index",  
                },
                    tooltips: {
                      callbacks: {
                            data (t, d) {
                                const xLabel = d.datasets[t.datasetIndex].label;
                                const yLabel = t.yLabel >= 1000 ? 'Rp.' + t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') : '$' + t.yLabel;
                                return xLabel + ': ' + yLabel;
                            }
                        }
                    },
                    scales: {
                        xAxes: [
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
@endpush --}}
@endsection