<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Posts List</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif; /* Use Roboto font family */
      background-color: #f5f5f5; /* Light gray background for the main content area */
    }

    /* Add custom styles here if needed */
    .post-container {
      transition: transform 0.3s ease-in-out; /* Add transition property for smooth animation */
      display: flex;
      flex-direction: column;
    }

    .post-link {
      transition: color 0.3s ease-in-out, background-color 0.3s ease-in-out; /* Add transition property for smooth color change */
      color: #1d4ed8; /* Default link color */
      background-color: #e9ebee; /* Default background color for links */
      padding: 0.75rem 1.5rem; /* Add padding for better appearance */
      border-radius: 0.5rem; /* Add border-radius for rounded corners */
      display: inline-block; /* Ensure the link displays as inline block */
      text-decoration: none; /* Remove default underline */
      font-weight: bold; /* Add bold font weight */
      text-transform: uppercase; /* Convert text to uppercase */
      letter-spacing: 1px; /* Add letter spacing */
    }

    .post-link:hover {
      color: #fff; /* Change text color on hover */
      background-color: #1877f2; /* Change background color on hover */
    }

    /* Adjust size of images */
    img.post-picture {
      width: 55%; /* Set width to 250px */
      height: 255px; /* Set height to 250px */
      object-fit: cover; /* Ensure the image covers the entire container */
      border-radius: 0.1rem;
      margin-bottom: 2rem; /* Add margin bottom for spacing */
      cursor: pointer; /* Add cursor pointer */
    }

    /* Common button styles */
    .post-button {
      display: inline-block;
      background-color: #1d4ed8;
      color: #ffffff;
      padding: 0.7rem 1rem; /* Adjust padding */
      border-radius: 0.5rem; /* Add border-radius for rounded corners */
      text-decoration: none;
      transition: background-color 0.3s ease-in-out;
      font-weight: bold; /* Add bold font weight */
      text-transform: uppercase; /* Convert text to uppercase */
      letter-spacing: 1px; /* Add letter spacing */
      border: none; /* Remove border */
      cursor: pointer; /* Add pointer cursor */
      outline: none; /* Remove outline */
      font-size: 0.7rem; /* Adjust font size for smaller size */
    }

    .post-button:hover {
      background-color: #1877f2;
    }

    /* Flex container for buttons */
    .button-container {
      display: flex;
      justify-content: space-between;
      margin-top: auto; /* Push the buttons to the bottom */
    }

    /* Style for "Impressions" */
    .impressions {
      font-family: 'Roboto', sans-serif; /* Change font family to 'Roboto' */
    }

    /* Style for "Pro" text and logo */
    .pro-logo-container {
      display: flex;
      align-items: center;
      justify-content: center; /* Center align */
    }

    .pro-text {
      margin-right: 5px; /* Add margin between "Pro" text and logo */
      color: #1d4ed8; /* Color of "Pro" text */
      font-weight: bold; /* Bold font weight for "Pro" text */
    }

    .facebook-logo {
      width: 27px; /* Adjust width of the Facebook logo */
      height: auto; /* Maintain aspect ratio */
    }

    /* Popup styles */
    #postPopup {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

   .popup-content {
  background-color: #fff;
  padding: 50px; /* Adjust padding as needed */
  border-radius: 8px;
  width: 60%; /* Set fixed width */
  height: 60%; /* Set fixed height */
  overflow: auto;
  position: relative; /* Ensure relative positioning for absolute positioning of image */
}

.popup-content img.post-picture {
  width: 55%; /* Set width to 55% */
  height: 255px; /* Set height to 255px */
  border-radius: 8px; /* Optional: Add border radius for image */
  position: absolute; /* Position the image absolutely */
  top: 0; /* Align to the top */
  left: 0; /* Align to the left */
  margin: 20px; /* Add margin for spacing */
  cursor: pointer; /* Change cursor to pointer */
}

    /* Add hover effect to indicate clickable image */
    .popup-content img.post-picture:hover {
      opacity: 0.8;
    }
  </style>
</head>

<body class="bg-[#3B5998]">
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4 text-center">Page Posts</h1>
    @if ($posts->isEmpty())
    <p class="text-gray-700 dark:text-gray-300">No posts available.</p>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      @foreach ($posts as $post)
      <div class="post-container bg-white rounded-lg shadow-md p-6">
        <div class="border-b border-gray-200 mb-4 pb-4">
          <div class="pro-logo-container">
            <img src="https://img.icons8.com/color/48/000000/facebook-new.png" alt="Facebook Logo" class="facebook-logo">
            <p class="text-gray-700 dark:text-gray-300 impressions pro-text">{{$post->from_name}}</p>
          </div>
          <h2 class="text-xl font-semibold mb-2 impressions">Post {{$post->id}}</h2>
          <p class="text-gray-700 dark:text-gray-300 impressions">Posted on:{{\Carbon\Carbon::parse($post->created_time)->format('D, d M Y H:i:s') }} ({{ \Carbon\Carbon::parse($post->created_time)->diffForHumans() }})</p>
          @if ($post->type == 'mobile_status_update')
          <p class="text-gray-700 dark:text-gray-300 impressions">Type: Status</p> <!-- Add class 'impressions' here -->
          @elseif ($post->type == 'added_video')
          <p class="text-gray-700 dark:text-gray-300 impressions">Type: Video</p> <!-- Add class 'impressions' here -->
          @elseif ($post->type == 'added_photos')
          <p class="text-gray-700 dark:text-gray-300 impressions">Type: Picture</p> <!-- Add class 'impressions' here -->
          @endif
        </div>
        @if ($post->type == 'mobile_status_update')
        @if (isset($post->picture_url))
        <div class="mb-4">
            <img src="{{$post->picture_url}}" alt="Post Picture" class="post-picture" onclick="window.location.href='{{ route('post.datails', $post->id) }}'">
          <p class="text-gray-700 dark:text-gray-300 impressions"> {{$post->message}}</p> <!-- Added message here -->
        </div>
        @else
        <div class="mb-4">
          <p class="text-gray-700 dark:text-gray-300 impressions"> {{$post->message}}</p> <!-- Add class 'impressions' here -->
        </div>
        @endif
        @elseif ($post->type == 'added_video')
        <div class="mb-4">
            <img src="{{$post->picture_url}}" alt="Post Picture" class="post-picture" onclick="window.location.href='{{ route('post.datails', $post->id) }}'">

          <p class="text-gray-700 dark:text-gray-300 impressions"> {{$post->message}}</p> <!-- Add class 'impressions' here -->
        </div>
        @elseif ($post->type == 'added_photos')
        <div class="mb-4">
            <img src="{{$post->picture_url}}" alt="Post Picture" class="post-picture" onclick="window.location.href='{{ route('post.datails', $post->id) }}'">

          <p class="text-gray-700 dark:text-gray-300 impressions"> {{$post->message}}</p> <!-- Add class 'impressions' here -->
        </div>
        @endif
        <div class="button-container">
          <a href="{{$post->permalink_url}}" class="post-button" target="_blank">View Post on Network</a>
          <a href="{{ route('comments.show', $post->id) }}" class="post-button">View Comments</a>
        </div>
      </div>
      @endforeach
    </div>
    <div class="mt-4 flex justify-center">
      {{ $posts->links() }}
    </div>
    @endif
  </div>

  <!-- Popup HTML -->
  <div id="postPopup">
    <div class="popup-content">
        <img id="popupImage" src="" alt="Post Picture" style="width: 230px; height: 230px;">
      <!-- Move the "Close" button further down by adding margin-top -->
      <button onclick="hidePopup({{$post->id}})" class="mt-8 block mx-auto px-4 py-2 bg-blue-500 text-white rounded-md">Close</button>
    </div>
  </div>


  <script>
    // Function to show the popup and set the image source
    function showPopup(imageUrl) {
      const popup = document.getElementById('postPopup');
      const popupImage = document.getElementById('popupImage');
      popupImage.src = imageUrl;
      popup.style.display = 'flex';
    }

    // Function to hide the popup
    function hidePopup(postId) {
  const popup = document.getElementById('postPopup');

  // Fetch data from the API
  fetch(`http://127.0.0.1:8000/api/posts/${postId}/detailspost`)
    .then(response => response.json())
    .then(data => {
      console.log(data); // Log the fetched data to the console
      popup.style.display = 'none'; // Hide the popup after fetching data
    })
    .catch(error => console.error('Error fetching data:', error));
}

  </script>
</body>

</html>
