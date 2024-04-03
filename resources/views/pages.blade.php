<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pages List</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300;400;600&display=swap">
  <style>
    body {
      font-family: 'Libre Franklin', sans-serif;
      background-color: #f5f5f5; /* Light gray background for the main content area */
    }

    .page-card {
      transition: transform 0.3s ease-in-out;
      transform-style: preserve-3d;
      padding: 2rem; /* Adjusted padding for better spacing */
      border: 1px solid #e2e8f0; /* Added subtle border */
      border-radius: .5rem;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); /* Added subtle shadow */
    }

    .page-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15); /* Adjusted hover shadow */
    }

    .page-card .absolute {
      transition: opacity 0.3s ease-in-out;
      opacity: 0.8;
    }

    .page-card:hover .absolute {
      opacity: 1;
    }

    .page-link {
      transition: color 0.3s ease-in-out, background-color 0.3s ease-in-out;
      color: #6b7280; /* Muted color for links */
      background-color: #e9ecef; /* Light gray background for links */
      padding: 0.5rem 1rem; /* Adjusted padding for links */
      border-radius: 0.25rem; /* Rounded corners for links */
      margin-bottom: 0.5rem; /* Spacing between links and text */
      margin-right:1rem;
    }

    .page-link:hover {
      color: #fff; /* White text color on hover */
      background-color: #1d4ed8; /* Adjusted hover background color (muted blue) */
    }

    #loading {
      display: none;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
    }

    #loading::after {
      content: "";
      display: inline-block;
      vertical-align: middle;
      height: 100px;
      width: 100px;
      border: 3px solid #f3f3f3;
      border-radius: 50%;
      border-top-color: #3498db;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }

    .category-badge {
      display: inline-block;
      padding: 0.5rem 1rem;
      border-radius: 0.25rem;
      font-size: 0.8rem;
      background-color: #e2e8f0; /* Muted background for category */
      color: #6b7280; /* Muted text color for category */
      margin-right: 0.5rem;
    }

    .text-truncate {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .text-center {
      margin-bottom: 1rem; /* Added margin */
      text-align: center; /* Align text to center */
    }
  </style>
</head>

<body>
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4 text-center">Pages</h1>

    @if ($pages->isEmpty())
    <p class="text-gray-700 dark:text-gray-300 text-center">No pages available.</p>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="pagesContainer">
      @foreach ($pages as $page)
      <div class="page-card bg-white rounded-lg shadow-md p-6 relative overflow-hidden">
        <div class="relative mb-4">
            <img src="{{ $page->cover_picture_url }}" alt="Cover photo of {{ $page->name_page }}" class="w-full h-40 object-cover rounded-t-lg">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-transparent to-black opacity-40"></div>
            <div class="absolute top-0 right-0 mt-4 mr-4 flex justify-center items-center">
              <div class="relative w-16 h-16 rounded-full overflow-hidden shadow-lg border-4 border-white">
                <img src="{{ $page->picture_url }}" alt="Photo of {{ $page->name_page }}" class="mx-auto rounded-full w-full h-full object-cover">
              </div>
            </div>
          </div>

        <div class="text-center">
          <h2 class="text-2xl font-bold mb-2">{{ $page->name_page }}</h2>
          <p class="text-gray-700 dark:text-gray-300"><strong>About:</strong> {{ $page->about }}</p>
          <p class="text-gray-700 dark:text-gray-300"><strong>Location:</strong> {{ $page->location }}</p>
          <p class="text-gray-700 dark:text-gray-300"><strong>Created:</strong> {{ $page->created_at->format('Y-m-d') }}</p>
          <p class="text-gray-700 dark:text-gray-300"><strong>Category:</strong> {{ $page->categorie }}</p>
        </div>
        <div class="flex justify-center mt-4">
          @if ($page->link)
          <a href="{{ $page->link }}" class="page-link">Visit Page</a>
          @else
          <p class="text-gray-500 text-sm">No link available</p>
          @endif
          <a href="page/{{ $page->id }}/posts" class="page-link">View Posts</a>
          <a href="page/{{ $page->id }}/details" class="page-link">Page Details</a>
        </div>
      </div>
      @endforeach
    </div>
    <div class="mt-4 flex justify-center">
      {{ $pages->links() }}
    </div>
    @endif
  </div>

  <div id="loading">
    <div></div>
  </div>

  <script>
    const pagesContainer = document.getElementById('pagesContainer');
    const loading = document.getElementById('loading');

    window.addEventListener('scroll', () => {
      if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
        // Show loading spinner
        loading.style.display = 'block';

        // Simulate loading delay
        setTimeout(() => {
          // Fetch more pages data here using AJAX

          // Append fetched data to pagesContainer

          // Hide loading spinner
          loading.style.display = 'none';
        }, 1000); // Change delay time as needed
      }
    });
  </script>
</body>

</html>
