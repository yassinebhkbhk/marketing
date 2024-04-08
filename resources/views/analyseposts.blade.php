<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Post Comments</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Libre Franklin', sans-serif;
      background-color: #f5f5f5; /* Light gray background for the main content area */
    }
    /* Custom styles */
    .table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1.5rem;
    }
    .table th,
    .table td {
      padding: 1rem;
      border: 1px solid #ddd;
      text-align: left;
    }
    .table th {
      background-color: #f8f9fa;
      font-weight: bold;
    }
  </style>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4 text-center">Post Details </h1>
    @if ($posts->isEmpty())
      <p class="text-gray-700 dark:text-gray-300">No post details available.</p>
    @else
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Value</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($posts as $post)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $post->name }}</td>
            <td>{{ $post->value }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</body>
</html>
