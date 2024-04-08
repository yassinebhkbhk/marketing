  <title>Post Comments</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
      body {
          font-family: 'Libre Franklin', sans-serif;
          background-color: #f5f5f5;
          /* Light gray background for the main content area */
      }

      /* Custom styles */
      .comment-container {
          background-color: #f8f9fa;
          border-radius: .5rem;
          box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
          transition: transform 0.3s ease-in-out;
          margin-bottom: 1.5rem;
          padding: 1.5rem;
      }

      .comment-container:hover {
          transform: translateY(-3px);
      }

      .comment-text {
          color: #333;
          max-height: 100px;
          overflow: hidden;
          transition: max-height 0.3s ease-in-out;
      }

      .comment-container:hover .comment-text {
          max-height: 300px;
      }

      h2 {
          font-family: inherit;
          font-size: 1.125rem;
          font-weight: 500;
          margin-bottom: .5rem;
      }

      .text-gray-500,
      .text-gray-700 {
          color: #6b7280;
      }
  </style>

  <x-app-layout>
      <div class="container mx-auto px-4 py-8">
          <h1 class="text-3xl font-bold mb-4 text-center">Post Comments </h1>
          @if ($comments->isEmpty())
              <p class="text-gray-700 dark:text-gray-300">No comments available.</p>
          @else
              <div class="grid grid-cols-1 gap-4">
                  @foreach ($comments as $comment)
                      <div class="comment-container">
                          <div class="border-b border-gray-200 pb-4">
                              <h2 class="text-lg font-semibold mb-2">{{ $loop->iteration }} - {{ $comment->name }}
                                  {{ $comment->created_at->format('D, d M Y H:i:s') }}
                                  ({{ $comment->created_at->diffForHumans() }})
                              </h2>
                              <p class="comment-text">{{ $comment->message }}</p>
                              @if (count($comment->analyseCommentaires))
                                  <p class="text-gray-500">Likes: {{ $comment->analyseCommentaires[0]['like_count'] }},
                                      Comments: {{ $comment->analyseCommentaires[0]['comment_count'] }}</p>
                              @endif
                          </div>
                      </div>
                  @endforeach
              </div>
          @endif
      </div>
  </x-app-layout>
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          // Add animation to comment containers on hover
          const commentContainers = document.querySelectorAll('.comment-container');
          commentContainers.forEach(commentContainer => {
              commentContainer.addEventListener('mouseenter', function() {
                  this.style.transform = 'translateY(-5px)';
              });
              commentContainer.addEventListener('mouseleave', function() {
                  this.style.transform = 'translateY(0)';
              });
          });
      });
  </script>
