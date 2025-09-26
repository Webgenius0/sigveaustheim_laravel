@extends('backend.app')

@section('title', 'Admin || Dashboard')

@section('content')
    <!--app-content open-->
    <div class="app-content main-content mt-0">
        <div class="side-app">

            <!-- CONTAINER -->
            <div class="main-container container-fluid">
                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Dashboard</h1>
                    </div>
                    <div class="ms-auto pageheader-btn">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!-- PAGE-HEADER END -->

                <!-- ROW-1 -->
                <div class="row">
                    <!-- Total Users -->
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="mb-2 fw-semibold">{{ $totalUsers }}</h3>
                                        <p class="text-muted fs-13 mb-0">Total Users</p>
                                    </div>
                                    <div class="col col-auto top-icn dash">
                                        <div class="counter-icon bg-primary dash ms-auto box-shadow-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                enable-background="new 0 0 24 24" viewBox="0 0 16 16">
                                                <path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                                                <path
                                                    d="m5.93 6.704-.846 8.451a.768.768 0 0 0 1.523.203l.81-4.865a.59.59 0 0 1 1.165 0l.81 4.865a.768.768 0 0 0 1.523-.203l-.845-8.451A1.5 1.5 0 0 1 10.5 5.5L13 2.284a.796.796 0 0 0-1.239-.998L9.634 3.84a.7.7 0 0 1-.33.235c-.23.074-.665.176-1.304.176-.64 0-1.074-.102-1.305-.176a.7.7 0 0 1-.329-.235L4.239 1.286a.796.796 0 0 0-1.24.998l2.5 3.216c.317.316.475.758.43 1.204Z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Schools -->
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="mb-2 fw-semibold">{{ $totalSchools }}</h3>
                                        <p class="text-muted fs-13 mb-0">Total Schools</p>
                                    </div>
                                    <div class="col col-auto top-icn dash">
                                        <div class="counter-icon bg-success dash ms-auto box-shadow-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                enable-background="new 0 0 24 24" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0M2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484-.08.08-.162.158-.242.234-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.5.3-.816.1-.493-.3-1.331-.956-2.175-1.665-.329-.277-.705-.568-1.078-.806C3.644 4.16 2.64 4.324 2.04 4.326" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Students -->
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="mb-2 fw-semibold">{{ $totalStudents }}</h3>
                                        <p class="text-muted fs-13 mb-0">Total Students</p>
                                    </div>
                                    <div class="col col-auto top-icn dash">
                                        <div class="counter-icon bg-info dash ms-auto box-shadow-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                enable-background="new 0 0 24 24" viewBox="0 0 16 16">
                                                <path
                                                    d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Tests -->
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="mb-2 fw-semibold">{{ $totalTests }}</h3>
                                        <p class="text-muted fs-13 mb-0">Total Tests</p>
                                    </div>
                                    <div class="col col-auto top-icn dash">
                                        <div class="counter-icon bg-warning dash ms-auto box-shadow-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                enable-background="new 0 0 24 24" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.5 2A1.5 1.5 0 0 1 7 .5h2A1.5 1.5 0 0 1 10.5 2v1A1.5 1.5 0 0 1 9 4.5H7A1.5 1.5 0 0 1 5.5 3z" />
                                                <path
                                                    d="M3 4.5h10A1.5 1.5 0 0 1 14.5 6v8a1.5 1.5 0 0 1-1.5 1.5H3A1.5 1.5 0 0 1 1.5 14V6A1.5 1.5 0 0 1 3 4.5M2.5 6v8a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V6a.5.5 0 0 0-.5-.5H3a.5.5 0 0 0-.5.5m2.5 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5A.5.5 0 0 1 5 8m0 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- Total Feedbacks -->
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="mb-2 fw-semibold">{{ $totalFeedbacks }}</h3>
                                        <p class="text-muted fs-13 mb-0">Total Feedbacks</p>
                                    </div>
                                    <div class="col col-auto top-icn dash">
                                        <div class="counter-icon bg-danger dash ms-auto box-shadow-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                enable-background="new 0 0 24 24" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                <path
                                                    d="M4.285 12.433a.5.5 0 0 0 .683-.183A3 3 0 0 1 8 10.5a3 3 0 0 1 3.032 1.75.5.5 0 1 0 .866-.5A4 4 0 0 0 8 9.5a4 4 0 0 0-3.898 3.183.5.5 0 0 0 .183.75M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Approved Schools -->
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="mb-2 fw-semibold">{{ $approvedSchools }}</h3>
                                        <p class="text-muted fs-13 mb-0">Approved Schools</p>
                                    </div>
                                    <div class="col col-auto top-icn dash">
                                        <div class="counter-icon bg-success dash ms-auto box-shadow-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                enable-background="new 0 0 24 24" viewBox="0 0 16 16">
                                                <path
                                                    d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Schools -->
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="mb-2 fw-semibold">{{ $pendingSchools }}</h3>
                                        <p class="text-muted fs-13 mb-0">Pending Schools</p>
                                    </div>
                                    <div class="col col-auto top-icn dash">
                                        <div class="counter-icon bg-secondary dash ms-auto box-shadow-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                enable-background="new 0 0 24 24" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                <path
                                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Feedbacks -->
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="mb-2 fw-semibold">{{ $activeFeedbacks }}</h3>
                                        <p class="text-muted fs-13 mb-0">Active Feedbacks</p>
                                    </div>
                                    <div class="col col-auto top-icn dash">
                                        <div class="counter-icon bg-primary dash ms-auto box-shadow-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                enable-background="new 0 0 24 24" viewBox="0 0 16 16">
                                                <path
                                                    d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                                <path
                                                    d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROW-1 END-->


                <!-- ROW-2: School Charts -->
                <div class="row">
                    <!-- School Status Chart -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">School Status Distribution</h3>
                            </div>
                            <div class="card-body">
                                <div id="school-status-piechart" style="width: 100%; height: 400px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- New School Registrations -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">New School Registrations (Last 30 Days)</h3>
                            </div>
                            <div class="card-body">
                                <div id="school-linechart" style="width: 100%; height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROW-2 END -->

                <!-- ROW-3: Student Charts -->
                <div class="row">
                    <!-- Student Gender Distribution -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">Student Gender Distribution</h3>
                            </div>
                            <div class="card-body">
                                <div id="gender-piechart" style="width: 100%; height: 400px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- New Student Registrations -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">New Student Registrations (Last 30 Days)</h3>
                            </div>
                            <div class="card-body">
                                <div id="student-linechart" style="width: 100%; height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROW-3 END -->

                <!-- ROW-4: Test Charts -->
                <div class="row">
                    <!-- Most Popular Tests -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">Most Popular Fitness Tests</h3>
                            </div>
                            <div class="card-body">
                                <div id="popular-tests-barchart" style="width: 100%; height: 400px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Daily Test Attempts -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">Daily Test Attempts (Last 30 Days)</h3>
                            </div>
                            <div class="card-body">
                                <div id="test-attempts-linechart" style="width: 100%; height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROW-4 END -->

                <!-- ROW-5: Feedback Chart -->
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">Feedback Ratings Distribution</h3>
                            </div>
                            <div class="card-body">
                                <div id="feedback-ratings-barchart" style="width: 100%; height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROW-5 END -->
            </div>
        </div>
    </div>
    <!-- CONTAINER CLOSED -->
@endsection


@push('scripts')
    <!-- Load required libraries -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.36.3/dist/apexcharts.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Load Google Charts
            google.charts.load('current', {
                'packages': ['corechart', 'bar']
            });
            google.charts.setOnLoadCallback(fetchDashboardData);

            function fetchDashboardData() {
                fetch('/admin/dashboard/data')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const contentType = response.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            throw new Error("Response wasn't JSON");
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Draw all charts
                        drawSchoolStatusPieChart(data.school_statuses);
                        drawSchoolRegistrationLineChart(data.new_school_registrations);
                        drawGenderPieChart(data.gender_distribution);
                        drawStudentRegistrationLineChart(data.new_student_registrations);
                        drawPopularTestsBarChart(data.popular_tests);
                        drawTestAttemptsLineChart(data.daily_test_attempts);
                        drawFeedbackRatingsBarChart(data.feedback_ratings);
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        alert('Failed to load dashboard data. Please try again later.');
                    });
            }

            // School Status Pie Chart
            function drawSchoolStatusPieChart(pieData) {
                var chartData = [
                    ['Status', 'Count'],
                    ['Pending', pieData.pending],
                    ['Approved', pieData.approved],
                    ['Cancelled', pieData.cancelled]
                ];

                var data = google.visualization.arrayToDataTable(chartData);

                var options = {
                    pieHole: 0.4,
                    colors: ['#FFA500', '#00E396', '#FF4560'],
                    chartArea: {
                        width: '90%',
                        height: '80%'
                    },
                    legend: {
                        position: 'bottom'
                    }
                };

                var chart = new google.visualization.PieChart(document.getElementById('school-status-piechart'));
                chart.draw(data, options);
            }

            // School Registration Line Chart
            function drawSchoolRegistrationLineChart(lineData) {
                const categories = Object.keys(lineData);
                const counts = Object.values(lineData);

                const options = {
                    series: [{
                        name: "New Schools",
                        data: counts,
                        color: '#00E396'
                    }],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: true
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    title: {
                        text: 'Daily School Registrations',
                        align: 'center'
                    },
                    xaxis: {
                        categories: categories,
                        labels: {
                            rotate: -45
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Number of Schools'
                        }
                    },
                    tooltip: {
                        shared: true,
                        intersect: false
                    }
                };
                const chart = new ApexCharts(document.querySelector("#school-linechart"), options);
                chart.render();
            }

            // Gender Distribution Pie Chart
            function drawGenderPieChart(pieData) {
                var chartData = [
                    ['Gender', 'Count'],
                    ['Male', pieData.male],
                    ['Female', pieData.female]
                ];

                var data = google.visualization.arrayToDataTable(chartData);

                var options = {
                    pieHole: 0.4,
                    colors: ['#008FFB', '#FF4560'],
                    chartArea: {
                        width: '90%',
                        height: '80%'
                    },
                    legend: {
                        position: 'bottom'
                    }
                };

                var chart = new google.visualization.PieChart(document.getElementById('gender-piechart'));
                chart.draw(data, options);
            }

            // Student Registration Line Chart
            function drawStudentRegistrationLineChart(lineData) {
                const categories = Object.keys(lineData);
                const counts = Object.values(lineData);

                const options = {
                    series: [{
                        name: "New Students",
                        data: counts,
                        color: '#775DD0'
                    }],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: true
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    title: {
                        text: 'Daily Student Registrations',
                        align: 'center'
                    },
                    xaxis: {
                        categories: categories,
                        labels: {
                            rotate: -45
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Number of Students'
                        }
                    },
                    tooltip: {
                        shared: true,
                        intersect: false
                    }
                };
                const chart = new ApexCharts(document.querySelector("#student-linechart"), options);
                chart.render();
            }

            // Popular Tests Bar Chart
            function drawPopularTestsBarChart(testData) {
                var chartData = [['Test Name', 'Attempts']];

                Object.entries(testData).forEach(([testName, count]) => {
                    chartData.push([testName, count]);
                });

                var data = google.visualization.arrayToDataTable(chartData);

                var options = {
                    colors: ['#FFB55A'],
                    chartArea: {
                        width: '70%',
                        height: '80%'
                    },
                    hAxis: {
                        title: 'Number of Attempts'
                    },
                    vAxis: {
                        title: 'Fitness Tests'
                    },
                    legend: {
                        position: 'none'
                    }
                };

                var chart = new google.visualization.BarChart(document.getElementById('popular-tests-barchart'));
                chart.draw(data, options);
            }

            // Test Attempts Line Chart
            function drawTestAttemptsLineChart(lineData) {
                const categories = Object.keys(lineData);
                const counts = Object.values(lineData);

                const options = {
                    series: [{
                        name: "Test Attempts",
                        data: counts,
                        color: '#FF4560'
                    }],
                    chart: {
                        height: 350,
                        type: 'area',
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: true
                        }
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            opacityFrom: 0.7,
                            opacityTo: 0.1,
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    title: {
                        text: 'Daily Test Attempts Activity',
                        align: 'center'
                    },
                    xaxis: {
                        categories: categories,
                        labels: {
                            rotate: -45
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Number of Attempts'
                        }
                    },
                    tooltip: {
                        shared: true,
                        intersect: false
                    }
                };
                const chart = new ApexCharts(document.querySelector("#test-attempts-linechart"), options);
                chart.render();
            }

            // Feedback Ratings Bar Chart
            function drawFeedbackRatingsBarChart(ratingsData) {
                var chartData = [['Rating', 'Count']];

                Object.entries(ratingsData).forEach(([rating, count]) => {
                    chartData.push([rating, count]);
                });

                var data = google.visualization.arrayToDataTable(chartData);

                var options = {
                    colors: ['#00BFFF'],
                    chartArea: {
                        width: '80%',
                        height: '80%'
                    },
                    hAxis: {
                        title: 'Number of Feedbacks'
                    },
                    vAxis: {
                        title: 'Rating'
                    },
                    legend: {
                        position: 'none'
                    }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('feedback-ratings-barchart'));
                chart.draw(data, options);
            }
        });
    </script>
@endpush




