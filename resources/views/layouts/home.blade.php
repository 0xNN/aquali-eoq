<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Aquali') }}</title>
    <link rel="shortcut icon" type="image/jpg" href="{{ asset('images') }}/aquali.jpg" />
    <link href="{{ asset('src') }}/assets/css/styles.min.css" rel="stylesheet">
    @yield('css')
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('layouts.sidebar')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            @include('layouts.header')
            <!--  Header End -->
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('src') }}/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('src') }}/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('src') }}/assets/js/sidebarmenu.js"></script>
    <script src="{{ asset('src') }}/assets/js/app.min.js"></script>
    <script src="{{ asset('src') }}/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="{{ asset('src') }}/assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="{{ asset('src') }}/assets/js/dashboard.js"></script>
    @yield('js')
    <script>
        $(function() {
            let barang = {!! json_encode($barang) !!};
            let nama = [];
            let eoq = [];
            let rop = [];
            let safety = [];
            let stok = [];
            barang.map((item) => {
                nama.push(item.nama_barang);
                eoq.push(item.eoq);
                rop.push(item.rop);
                safety.push(item.safety_stok);
                stok.push(item.stok);
            })
            var chart = {
                series: [{
                        name: "EOQ",
                        data: eoq
                    },
                    {
                        name: "ROP",
                        data: rop
                    },
                    {
                        name: "Safety Stok",
                        data: safety
                    }
                ],

                chart: {
                    type: "bar",
                    height: 345,
                    offsetX: -15,
                    toolbar: {
                        show: true
                    },
                    foreColor: "#adb0bb",
                    fontFamily: 'inherit',
                    sparkline: {
                        enabled: false
                    },
                },


                colors: ["#5D87FF", "#49BEFF", "#FFBC44"],


                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "35%",
                        borderRadius: [6],
                        borderRadiusApplication: 'end',
                        borderRadiusWhenStacked: 'all'
                    },
                },
                markers: {
                    size: 0
                },

                dataLabels: {
                    enabled: false,
                },


                legend: {
                    show: false,
                },


                grid: {
                    borderColor: "rgba(0,0,0,0.1)",
                    strokeDashArray: 3,
                    xaxis: {
                        lines: {
                            show: false,
                        },
                    },
                },

                xaxis: {
                    type: "category",
                    categories: nama,
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color"
                        },
                    },
                },


                yaxis: {
                    show: true,
                    min: 0,
                    // max: 1000,
                    tickAmount: 4,
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color",
                        },
                    },
                },
                stroke: {
                    show: true,
                    width: 3,
                    lineCap: "butt",
                    colors: ["transparent"],
                },


                tooltip: {
                    theme: "light"
                },

                responsive: [{
                    breakpoint: 600,
                    options: {
                        plotOptions: {
                            bar: {
                                borderRadius: 3,
                            }
                        },
                    }
                }]


            };

            var chart = new ApexCharts(document.querySelector("#chart"), chart);
            chart.render();

            var earning = {
                chart: {
                    id: "sparkline3",
                    type: "area",
                    height: 60,
                    sparkline: {
                        enabled: true,
                    },
                    group: "sparklines",
                    fontFamily: "Plus Jakarta Sans', sans-serif",
                    foreColor: "#adb0bb",
                },
                series: [{
                    name: "Stok",
                    color: "#49BEFF",
                    data: stok,
                }, ],
                stroke: {
                    curve: "smooth",
                    width: 2,
                },
                fill: {
                    colors: ["#f3feff"],
                    type: "solid",
                    opacity: 0.05,
                },

                markers: {
                    size: 0,
                },
                tooltip: {
                    theme: "dark",
                    fixed: {
                        enabled: true,
                        position: "right",
                    },
                    x: {
                        show: false,
                    },
                },
            };
            new ApexCharts(document.querySelector("#earning"), earning).render();
        });
    </script>
</body>

</html>
