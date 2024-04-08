  <title>Posts List</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
      body {
          font-family: 'Libre Franklin', sans-serif;
          background-color: #f5f5f5;
          /* Light gray background for the main content area */
      }

      /* Add custom styles here if needed */
      .post-container {
          transition: transform 0.3s ease-in-out;
          /* Add transition property for smooth animation */
      }

      .post-link {
          transition: color 0.3s ease-in-out, background-color 0.3s ease-in-out;
          /* Add transition property for smooth color change */
          color: #1d4ed8;
          /* Default link color */
          background-color: #e9ebee;
          /* Default background color for links */
          padding: 0.5rem 1rem;
          /* Add padding for better appearance */
          border-radius: 0.25rem;
          /* Add border-radius for rounded corners */
      }

      .post-link:hover {
          color: #fff;
          /* Change text color on hover */
          background-color: #1877f2;
          /* Change background color on hover */
      }

      /* Adjust size of images */
      img.post-picture {
          width: 160px;
          height: 160px;
          object-fit: cover;
          /* Ensure the image covers the entire container */
          border-radius: 0.4rem;
          margin-bottom: 1rem;
          /* Add border-radius for rounded corners */
      }
  </style>

  <x-app-layout>

      <x-slot name="header">
          <h2 class="font-semibold text-lg text-blue-600 leading-tight">
              {{ __('Page Posts') }}
          </h2>
      </x-slot>
      <div class="bg-[#3B5998]">
          <div class="container mx-auto px-4 py-8">
              <h1 class="text-3xl font-bold mb-4 text-center">Page Posts</h1>
              @if ($posts->isEmpty())
                  <p class="text-gray-700 dark:text-gray-300">No posts available.</p>
              @else
                  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                      @foreach ($posts as $post)
                          <div class="post-container bg-white rounded-lg shadow-md p-6">
                              <div class="border-b border-gray-200 mb-4 pb-4">
                                  <h2 class="text-xl font-semibold mb-2">Post {{ $post->id }}</h2>
                                  <p class="text-gray-700 dark:text-gray-300">Page: {{ $post->from_name }}</p>
                                  <p class="text-gray-700 dark:text-gray-300">Created Time:
                                      {{ \Carbon\Carbon::parse($post->created_time)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}
                                  </p>
                                  @if ($post->type == 'mobile_status_update')
                                      <p class="text-gray-700 dark:text-gray-300">Type: Status</p>
                                  @elseif ($post->type == 'added_video')
                                      <p class="text-gray-700 dark:text-gray-300">Type: Video</p>
                                  @elseif ($post->type == 'added_photos')
                                      <p class="text-gray-700 dark:text-gray-300">Type: Picture</p>
                                  @endif
                              </div>
                              @if ($post->type == 'mobile_status_update')
                                  @if (isset($post->picture_url))
                                      <div class="mb-4">
                                          <img src="{{ $post->picture_url }}" alt="Post Picture" class="post-picture">
                                          <p class="text-gray-700 dark:text-gray-300"> {{ $post->message }}</p>
                                          <!-- Added message here -->
                                      </div>
                                  @else
                                      <div class="mb-4">
                                          <p class="text-gray-700 dark:text-gray-300"> {{ $post->message }}</p>
                                      </div>
                                  @endif
                              @elseif ($post->type == 'added_video')
                                  <div class="mb-4">
                                      <img src="{{ $post->picture_url }}" alt="Post Picture" class="post-picture">
                                      <p class="text-gray-700 dark:text-gray-300"> {{ $post->message }}</p>
                                  </div>
                              @elseif ($post->type == 'added_photos')
                                  <div class="mb-4">
                                      <img src="{{ $post->picture_url }}" alt="Post Picture" class="post-picture">
                                      <p class="text-gray-700 dark:text-gray-300"> {{ $post->message }}</p>
                                      <!-- Added message here -->
                                  </div>
                              @endif
                              <div class="mt-4">
                                  <a href="{{ route('comments.show', $post->id) }}" class="post-link">View Comments</a>
                              </div>
                          </div>
                      @endforeach
                  </div>
                  <div class="mt-4 flex justify-center">
                      {{ $posts->links() }}
                  </div>
              @endif
          </div>

          <script>
              document.addEventListener('DOMContentLoaded', function() {
                  const postContainers = document.querySelectorAll('.post-container');
                  postContainers.forEach(postContainer => {
                      postContainer.addEventListener('mouseenter', function() {
                          this.style.transform = 'translateY(-5px)';
                      });
                      postContainer.addEventListener('mouseleave', function() {
                          this.style.transform = 'translateY(0)';
                      });
                  });
              });
          </script>
      </div>
  </x-app-layout>
