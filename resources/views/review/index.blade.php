<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Reviews - MEDBook</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- Same styles as your main app -->
    <style>
        body {
            background-color: #121212;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: white;
        }
        .med-teal {
            color: #00CCCC;
        }
        .btn-teal {
            background-color: #00CCCC;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-teal:hover {
            box-shadow: 0 4px 15px rgba(0, 204, 204, 0.5);
            transform: translateY(-2px);
        }
        .card {
            background: rgba(40, 40, 40, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.4s ease;
            border-radius: 16px;
        }
        .rating {
            color: #FFD700;
        }
        /* Additional styles for reviews */
        .review-item {
            background-color: #1E1E1E;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 3px solid #00CCCC;
            transition: all 0.3s ease;
        }
        .review-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="flex min-h-screen">
        <!-- Sidebar (same as in your main application) -->

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Header -->
            <div class="mb-10">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">Reviews for Dr. {{ $doctor->name }}</h1>
                        <p class="text-gray-400 mt-1">{{ count($reviews) }} reviews • Average Rating: {{ number_format($doctor->rating, 1) }}</p>
                    </div>
                    <a href="{{ route('patient.explore') }}" class="btn-teal px-4 py-2 rounded-lg text-sm flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Doctors
                    </a>
                </div>
            </div>

            <!-- Notification Alerts -->
            @if(session('success'))
                <div class="bg-green-600 text-white p-4 rounded-lg mb-6 shadow-lg animate-fade-in">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-600 text-white p-4 rounded-lg mb-6 shadow-lg animate-fade-in">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Doctor Profile Summary -->
            <div class="card p-6 mb-8">
                <div class="flex items-start">
                    <div class="h-20 w-20 rounded-full bg-gray-700 flex items-center justify-center mr-6">
                        @if($doctor->profile_picture)
                            <img src="{{ asset('storage/' . $doctor->profile_picture) }}" class="h-20 w-20 rounded-full object-cover" />
                        @else
                            <span class="text-white font-semibold text-xl">{{ substr($doctor->name, 0, 2) }}</span>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">Dr. {{ $doctor->name }}</h2>
                        <div class="flex items-center mt-1">
                            <div class="rating flex items-center">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < floor($doctor->rating))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                                            <path d="M12 2l2.928 6.515L22 9.271l-5.024 4.367 1.431 7.362L12 17.467 5.593 21l1.431-7.362L2 9.271l7.072-0.756L12 2z"/>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" stroke="none" opacity="0.3">
                                            <path d="M12 2l2.928 6.515L22 9.271l-5.024 4.367 1.431 7.362L12 17.467 5.593 21l1.431-7.362L2 9.271l7.072-0.756L12 2z"/>
                                        </svg>
                                    @endif
                                @endfor
                                <span class="ml-2 text-sm font-medium text-gray-300">{{ number_format($doctor->rating, 1) }}</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap mt-3">
                            @if($doctor->specialties)
                                @foreach($doctor->specialties as $specialty)
                                <div class="specialty-tag">{{ $specialty->name }}</div>
                                @endforeach
                            @endif
                        </div>

                        <button id="writeReviewBtn" class="mt-4 btn-teal px-4 py-2 rounded-lg text-sm font-medium">
                            Write a Review
                        </button>
                    </div>
                </div>
            </div>

            <!-- Write Review Form -->
            <div id="reviewFormContainer" class="card p-6 mb-8" style="display: none;">
                <h3 class="text-xl font-bold mb-4">Write Your Review</h3>

                <form action="{{ route('reviews.store', $doctor->id) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-400 mb-2">Your Rating</label>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5" />
                            <label for="star5" title="5 stars"></label>
                            <input type="radio" id="star4" name="rating" value="4" />
                            <label for="star4" title="4 stars"></label>
                            <input type="radio" id="star3" name="rating" value="3" />
                            <label for="star3" title="3 stars"></label>
                            <input type="radio" id="star2" name="rating" value="2" />
                            <label for="star2" title="2 stars"></label>
                            <input type="radio" id="star1" name="rating" value="1" />
                            <label for="star1" title="1 star"></label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="comment" class="block text-gray-400 mb-2">Your Review</label>
                        <textarea id="comment" name="comment" rows="4" class="w-full px-3 py-2 rounded-lg input-field" placeholder="Share your experience with this doctor..."></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" id="cancelReviewBtn" class="px-4 py-2 mr-3 bg-gray-700 hover:bg-gray-600 rounded-lg text-sm font-medium">
                            Cancel
                        </button>
                        <button type="submit" class="btn-teal px-6 py-2 rounded-lg text-sm font-medium">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>

            <!-- Reviews List -->
            <div class="mb-10">
                <h3 class="text-xl font-bold mb-6">Patient Reviews</h3>

                @if(count($reviews) > 0)
                    @foreach($reviews as $review)
                    <div class="review-item">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start">
                                <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center mr-4">
                                    <span class="text-white font-semibold">{{ substr($review->patient->name, 0, 2) }}</span>
                                </div>
                                <div>
                                    <div class="font-medium">{{ $review->patient->name }}</div>
                                    <div class="rating flex items-center mt-1">
                                        @for($i = 0; $i < 5; $i++)
                                            @if($i < $review->rating)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                                                    <path d="M12 2l2.928 6.515L22 9.271l-5.024 4.367 1.431 7.362L12 17.467 5.593 21l1.431-7.362L2 9.271l7.072-0.756L12 2z"/>
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" stroke="none" opacity="0.3">
                                                    <path d="M12 2l2.928 6.515L22 9.271l-5.024 4.367 1.431 7.362L12 17.467 5.593 21l1.431-7.362L2 9.271l7.072-0.756L12 2z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                        <span class="text-xs text-gray-400 ml-2">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            @if($review->patient_id === Auth::id())
                            <form action="{{ route('reviews.destroy', ['doctorId' => $doctor->id, 'reviewId' => $review->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 text-sm">
                                    Delete
                                </button>
                            </form>
                            @endif
                        </div>

                        <div class="mt-3 text-gray-300">
                            {{ $review->comment }}
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-12 bg-gray-800 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        <p class="text-gray-400">No reviews yet. Be the first to share your experience with Dr. {{ $doctor->name }}!</p>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <footer class="py-12 mt-16 border-t border-gray-800">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-6 md:mb-0">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <span class="med-teal text-2xl font-bold logo-pulse">MED</span><span class="text-2xl font-bold text-white">Book</span>
                        </a>
                        <p class="text-gray-400 mt-2">Your health, our priority</p>
                    </div>
                    <div class="flex space-x-6">
                        <a href="#" class="text-white hover:text-teal-300 transition-colors">Contact</a>
                        <a href="#" class="text-white hover:text-teal-300 transition-colors">About us</a>
                        <a href="#" class="text-white hover:text-teal-300 transition-colors">Privacy Policy</a>
                    </div>
                </div>
                <div class="text-center mt-8 text-gray-500 text-sm">
                    © 2025 MEDBook. All rights reserved.
                </div>
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle review form
            $('#writeReviewBtn').click(function() {
                $('#reviewFormContainer').slideDown();
                $(this).hide();
            });

            $('#cancelReviewBtn').click(function() {
                $('#reviewFormContainer').slideUp();
                $('#writeReviewBtn').show();
                $('.star-rating input:checked').prop('checked', false);
                $('.star-rating label').removeClass('active');
            });

            // Star Rating Interaction
            $('.star-rating input').hide();

            $('.star-rating label').hover(
                function() {
                    $(this).prevAll().andSelf().addClass('hover');
                },
                function() {
                    $(this).siblings().andSelf().removeClass('hover');
                }
            );

            $('.star-rating input').click(function() {
                $('.star-rating label').removeClass('active');
                $(this).prevAll().andSelf().addClass('active');
            });

            $('.star-rating label').click(function() {
                $(this).siblings().removeClass('active');
                $(this).prevAll().andSelf().addClass('active');
                const ratingValue = $(this).prev('input').val();
                $(`input[name="rating"][value="${ratingValue}"]`).prop('checked', true);
            });
        });
    </script>
    <style>
        /* Star Rating Styles */
        .star-rating {
            direction: rtl;
            unicode-bidi: bidi-override;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            font-size: 0;
            width: 30px;
            height: 30px;
            display: inline-block;
            cursor: pointer;
            position: relative;
        }
        .star-rating label::before {
            content: '★';
            font-size: 32px;
            color: #666;
            position: absolute;
            left: 0;
            transition: all 0.2s ease;
        }
        .star-rating label:hover::before,
        .star-rating label:hover ~ label::before,
        .star-rating input:checked ~ label::before,
        .star-rating label.active::before,
        .star-rating label.hover::before {
            color: #FFD700;
        }

        /* Specialty Tags */
        .specialty-tag {
            background: rgba(0, 204, 204, 0.1);
            color: #00CCCC;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            margin: 4px 4px 4px 0;
        }

        /* Animations */
        @keyframes animate-fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>
