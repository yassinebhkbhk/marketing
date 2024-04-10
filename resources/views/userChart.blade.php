<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>User Chart</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<style>
    h1 {
        text-align: center;
        color: red;
    }

    #chart-container {
        width: 70%;
        /* Adjust as needed */
        margin: 0 auto;
        /* Center the container */
    }

    canvas {
        width: 100%;
        height: auto;
    }

    /* Custom input styles */
    input[type="number"] {
        background-color: #f8f8f8;
        border: 1px solid #ccc;
        padding: 8px 12px;
        font-size: 16px;
        width: 100px;
        border-radius: 4px;
        outline: none;
    }

    /* Style for label */
    label {
        display: block;
        margin-bottom: 5px;
        font-size: 18px;
        color: #333;
    }

    /* Style for filter button */
    button[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>
<x-app-layout>
    <h1>User Chart</h1>

    <!-- Filter Form -->
    <form action="{{ route('user.chart') }}" method="GET">
        <label for="year">Enter a year:</label>
        <input type="number" name="year" id="year" min="2010" max="{{ date('Y') }}"
            value="{{ $selectedYear ?? date('Y') }}">
        <button type="submit">Filter</button>
    </form>

    <!-- Chart -->
    <div id="chart-container">
        <canvas id="userChart"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('userChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: {!! json_encode($datasets) !!}
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</x-app-layout>
