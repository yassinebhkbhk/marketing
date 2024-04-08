<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page Details (Pro Edition)</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.css">
    <style>
        /* Custom styles */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            border: 1px solid #007bff;
            /* Border color */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
            /* Title color */
        }

        .card-text {
            font-size: 1rem;
            color: #333;
            /* Text color */
        }

        .cursor-pointer {
            cursor: pointer;
        }

        /* Chart container */
        .chart-container {
            position: relative;
            margin-top: 20px;
            height: 400px;
            width: 80%;
            max-width: 800px;
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mb-4">Page Details</h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Fan Count</h5>
                        <p class="card-text fan-count cursor-pointer" data-toggle="tooltip" data-placement="top"
                            data-html="true" title="The total number of users who have chosen to follow the page.">
                            <strong>{{ $fanCount }}</strong>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Rating Count</h5>
                        <p class="card-text rating-count cursor-pointer" data-toggle="tooltip" data-placement="top"
                            data-html="true" title="The total number of ratings given to the page."><strong>{{
                                $ratingCount }}</strong></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Page Posts</h5>
                        <p class="card-text cursor-pointer" data-toggle="tooltip" data-placement="top" data-html="true" title="The total number of page posts.">
                            <strong>{{ $numberOfPagePosts }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <h2 class="text-center mb-3">Page Impressions</h2>
        <div class="chart-container">
            <canvas id="myChart"></canvas>
        </div>
        @if ($totalPageImpressions > 0)
            <p class="text-center mt-3">Total Page Impressions for the Month: <strong>{{ $totalPageImpressions }}</strong></p>
        @else
            <p class="text-center mt-3">No page impressions data available</p>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Define the page impressions data
        var pageImpressionsData = {!! json_encode($page_impressions_data) !!};

        // Extract labels and data from the fetched data
        var labels = pageImpressionsData.map(entry => entry.date);
        var data = pageImpressionsData.map(entry => entry.value);
        var time = labels.map(label => {
            return new Date(label).toLocaleString('default', { day: 'numeric', month: 'short' });
        });

        // Create the chart
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: time,
                datasets: [{
                    label: 'Page Impressions',
                    data: data,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Date'
                        }
                    }],
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                }
            }
        });
    </script>
</body>

</html>
