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

    <x-app-layout>
        <div class="container">
            <h1 class="text-center">Page Details </h1>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Fan Count</h5>
                            <!-- Use span with data attribute for tooltip -->
                            <p class="card-text fan-count cursor-pointer" data-toggle="tooltip" data-placement="top"
                                data-html="true" title="The total number of users who have chosen to follow the page.">
                                <strong>{{ $fanCount }}</strong>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Rating Count</h5>
                            <!-- Use span with data attribute for tooltip -->
                            <p class="card-text rating-count cursor-pointer" data-toggle="tooltip" data-placement="top"
                                data-html="true" title="The total number of ratings given to the page.">
                                <strong>{{ $ratingCount }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </x-app-layout>
