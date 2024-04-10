<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Post Statistics</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body {
        font-family: 'Libre Franklin', sans-serif;
        background-color: #f5f5f5;
        /* Light gray background for the main content area */
        font-size: 16px;
        /* Global font size */
    }

    /* Custom styles */
    .container {
        text-align: center;
        /* Center the cards */
        white-space: nowrap;
        /* Prevent line breaks */
        margin-top: 30px;
        /* Add margin to the top */
    }

    .card {
        width: 290px;
        /* Set a fixed width for all cards */
        height: 125px;
        /* Set a fixed height for all cards */
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        display: inline-block;
        margin: 0 10px;
        vertical-align: top;
        position: relative;
        /* Position for pseudo-element */
    }

    .card-content {
        flex-grow: 1;
    }

    .card-content p {
        font-size: 16px;
        /* Set the font size */
        font-weight: normal;
        /* Set the font weight */
        margin: 0;
        /* Remove any default margin */
    }

    .card-header {
        padding: 10px 0;
        cursor: pointer;
        /* Keep cursor style */
        position: relative;
        /* Position for pseudo-element */
    }

    .card-header::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 1px;
        background-color: #f44e57;
        /* Line color */
    }

    .reaction-container {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 10px;
    }

    .reaction {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .reaction-icon {
        width: 30px;
        height: 30px;
    }

    .reaction-value {
        font-size: 1rem;
        font-weight: bold;
        color: #1877f2;
        /* Facebook blue */
    }

    .hidden {
        display: none;
    }

    .tooltip {
        width: 220px;
        background-color: #fbf7f7 !important;
        /* Tooltip background color */
        color: #652525 !important;
        /* Tooltip text color */
        text-align: center;
        border-radius: 6px;
        padding: 5px 10px;
        position: absolute;
        z-index: 1;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .card:hover .tooltip {
        opacity: 1;
    }

    .value {
        color: #1877f2;
        /* Facebook blue */
    }

    /* Adjusted size for the canvas */
    #pieChart {
        width: 300px;
        height: 50px;
        margin: 0 auto;
        display: block;
    }

    .chart-card {
        text-align: center;
    }

    .chart-card .card {
        width: 1000px;
        /* Increase the width as needed */
        height: 200px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin: 20px auto;
    }
</style>

<x-app-layout>
    <div class="container">
        <!-- Post Statistics Cards -->
        <div class="post-cards overflow-x-scroll p-3 scroll-smooth">
            <!-- Post Impression Card -->
            <div class="card" title="The number of times your Page's post entered a person's screen.">
                <div class="card-header">Post Impression</div>
                <div class="card-content">
                    <p><span class="value">{{ $impressions }}</span></p>
                </div>
            </div>

            <!-- Post Clicks Card -->
            <div class="card"
                title="The number of clicks anywhere in your post on News Feed from the user that matched the audience targeting on it.">
                <div class="card-header">Post Clicks</div>
                <div class="card-content">
                    <p><span class="value">{{ $clicks }}</span></p>
                </div>
            </div>
            @if ($post->type == 'added_video')
                <div class="card"
                    title="The number of clicks anywhere in your post on News Feed from the user that matched the audience targeting on it.">
                    <div class="card-header">Number of Views</div>
                    <div class="card-content">
                        <p><span class="value">{{ $numbreofviews }}</span></p>
                    </div>
                </div>
            @endif
            <!-- Post Negative Feedback Card -->
            <div class="card" title="The number of times people have given negative feedback to your post.">
                <div class="card-header">Post Negative Feedback</div>
                <div class="card-content">
                    <p><span class="value">{{ $negativeFeedback }}</span></p>
                </div>
            </div>

            <!-- Post Engaged Fan Card -->
            <div class="card"
                title="The number of people who have liked your Page and clicked anywhere in your posts.">
                <div class="card-header">Post Engaged Fan</div>
                <div class="card-content">
                    <p><span class="value">{{ $engagedFans }}</span></p>
                </div>
            </div>
            <!-- Post Reactions Card -->
            <div class="card">
                <div class="card-header" id="postReactions">Post Reactions {{ $reactionTotals['totalReactions'] }}</div>
                <div class="card-content">
                    <div id="detailedReactions" class="hidden reaction-container">
                        <div class="reaction">
                            <img src="{{ asset('images/like.png') }}" alt="Like" class="reaction-icon">
                            <span class="value">{{ $reactionTotals['like'] }}</span>
                        </div>
                        <div class="reaction">
                            <img src="{{ asset('images/love.png') }}" alt="Love" class="reaction-icon">
                            <span class="value">{{ $reactionTotals['love'] }}</span>
                        </div>
                        <div class="reaction">
                            <img src="{{ asset('images/wow.png') }}" alt="Wow" class="reaction-icon">
                            <span class="value">{{ $reactionTotals['wow'] }}</span>
                        </div>
                        <div class="reaction">
                            <img src="{{ asset('images/haha.png') }}" alt="Haha" class="reaction-icon">
                            <span class="value">{{ $reactionTotals['haha'] }}</span>
                        </div>
                        <div class="reaction">
                            <img src="{{ asset('images/sorry.png') }}" alt="Sorry" class="reaction-icon">
                            <span class="value">{{ $reactionTotals['sorry'] }}</span>
                        </div>
                        <div class="reaction">
                            <img src="{{ asset('images/anger.png') }}" alt="Anger" class="reaction-icon">
                            <span class="value">{{ $reactionTotals['anger'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Divider -->
    <div class="divider"></div>
    <div class="chart-card">
        <div class="card" style="width: 500px;height: 400px; margin: 100px auto;">
            <div class="card-header">Distribution of Total Reactions by Reaction Type</div>
            <div class="card-content" style="padding: 20px;">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
    </div>
    </body>

    </html>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const detailedReactions = document.getElementById('detailedReactions');
            const postReactions = document.getElementById('postReactions');
            postReactions.addEventListener('click', function() {
                detailedReactions.classList.toggle('hidden');
            });

            // Data
            const reactionTypes = ["Like", "Love", "Wow", "Haha", "Sorry", "Anger"];
            const reactionCounts = [{{ $reactionTotals['like'] }}, {{ $reactionTotals['love'] }},
                {{ $reactionTotals['wow'] }}, {{ $reactionTotals['haha'] }}, {{ $reactionTotals['sorry'] }},
                {{ $reactionTotals['anger'] }}
            ]; // Sample data, replace with your actual counts

            // Calculate percentages
            const totalReactions = reactionCounts.reduce((total, count) => total + count, 0);
            const percentages = reactionCounts.map(count => ((count / totalReactions) * 100).toFixed(2));

            // Chart
            const ctx = document.getElementById('pieChart').getContext('2d');
            const pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: reactionTypes,
                    datasets: [{
                        data: percentages,
                        backgroundColor: ['#1877f2', '#f02849', '#fbbc05', '#ff7e29', '#ea4c89',
                            '#ed4242'
                        ], // Facebook colors
                    }]
                },
                options: {
                    legend: {
                        position: 'bottom',
                    },
                }
            });
        });
    </script>
</x-app-layout>
