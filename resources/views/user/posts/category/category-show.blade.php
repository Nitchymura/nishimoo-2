@extends('layouts.app')

@section('title', 'Category')

@section('content')

<div class="row justify-content-center mt-5 pt-5" >
    <div class="col " >
        <h3 class="h1 text-start text-secondary fw-bold mb-4"> 
            @if($category->id == 1)
                <span class="badge bg-success bg-opacity-30 mb-2">
            @elseif($category->id == 2)
                <span class="badge bg-primary bg-opacity-30mb-2">
            @elseif($category->id == 3)
                <span class="badge bg-warning bg-opacity-30">                
            @elseif($category->id == 4)
                <span class="badge bg-danger bg-opacity-30 mb-2">
            @endif {{$category->name}}</span></h4>       
    </div>
</div>

    <div class="row gx-5">
    @foreach($all_posts as $post)
        <div class="col-lg-4 col-md-6 col-sm-12 px-2">
            <div class="card mb-4">
                <!-- title -->
                @include('user.posts.category.contents.title')
                <!-- image -->
                <div class="container p-0">
                    <a href="{{route('post.show', $post->id)}}">
                        @if($post->image)
                            <img src="{{$post->image}}" alt="" class="w-100" style="height: 250px; object-fit: cover">
                        @else
                            <i class="fa-solid fa-image fa-5x text-center"></i>
                        @endif
                    </a>
                </div>
                <!-- body -->
                <div class="card-body">
                    @include('user.posts.category.contents.body')
                    <!-- COMMENTS -->
                    {{-- @if($post->comments->isNotEmpty())
                        <hr class="mt-3 mb-1">
                        @foreach($post->comments->take(3) as $comment)
                            @include('user.posts.category.contents.comments.list-item')
                        @endforeach
                        @if($post->comments->count() > 3)
                            <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none small mt-2">
                                View all {{ $post->comments->count() }} comments
                            </a>
                        @endif
                    @endif --}}
                    {{-- @include('user.posts.category.contents.comments.create') --}}
                </div>
            </div>
        </div>
    @endforeach
    </div>
                <div class="d-flex justify-content-end">
                {{ $all_posts->links() }}
            </div>


@endsection