@extends('layouts.app')

@section('content')
    <h1 class="mb-10 text-2xl">Books</h1>

    <form method = "GET" action = "{{route ('books.index') }}" class = "mb-4 flex items-center gap-2">
        <input type = "text" name = "title" placeholder ="Search by Title" value = "{{request('title')}}" class = "input h-10"/>
        <input type = "hidden" name = "filter" value = "{{request('filter')}}"/>
        <button type="submit" class="btn h-10">Search</button>
        <a href = "{{route('books.index')}}" class = "btn h-10">Reset</a>
       
    </form>

    <div class="filter-container mb-4 flex">
        @php
        $filters = [
            '' => 'Latest',
            'popular_last_month' => 'Popular Last Month',
            'popular_last_6months' => 'Popular Last 6 Months',
            'highest_rated_last_month' => 'Highest Rated Last Month',
            'highest_rated_last_6months' => 'Highest Rated Last 6 Months',
        ];
        @endphp

        @foreach ($filters as $key => $label)
            <a href="{{ route('books.index', array_merge(request()->query(), ['filter' => $key, 'title' => request('title')])) }}"
            class="{{ request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item' }}">
                {{ $label }}
            </a>
        @endforeach

    </div>
    
    <ul>
        @forelse($books as $book)
        <li class="mb-4">
            <div class="book-item">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="w-full flex-grow sm:w-auto">
                        <a href="{{ route('books.show', $book) }}" class="book-title">{{ $book->title }}</a>
                        <span class="book-author">{{$book -> author}}</span>
                    </div>
                    <div>
                        <div class="book-rating">
                            {{number_format($book->reviews_avg_rating, 1)}}
                        </div>
                        <div class="book-review-count">
                            out of {{$book->reviews_count}} review(s)
                        </div>
                    </div>
                </div>
            </div>
        </li>
        @empty
            <div class="empty-book-item">
                <li class="empty-book-item">
                    <p class="empty-text">No books found.</p>
                    <a href="{{route('books.index')}}" class="reset-link">Reset Criteria</a>
                </li>
            </div>
        @endforelse
    </ul>
@endsection