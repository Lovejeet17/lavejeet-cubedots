@extends('layouts.posts')

@section('content')

    <h4>All Posts</h4>
    
    <a class="btn btn-primary" href="{{ URL::to('/post') }}" role="button">Create New post</a>

    <div class="well">
        <h6>Choose Any Tag For Fliter Posts</h6>
        @foreach ($tags as $tag)
        <a href="{{ $tag->id }}"><span class="label label-default">{{ $tag->name }}</span></a>
        @endforeach
    </div>

    @foreach ($posts as $post)
    <div class="well">
        <div class="media">
            <a class="pull-left" href="">
                @if ($post->featured_image)
                <img class="media-object" src="{{ '/storage/thumbnails/'.$post->featured_image }}">
                @endif
            </a>
            <div class="media-body">
              <h4 class="media-heading">{{ $post->title }}</h4>
                <p>{{ $post->description }}</p>
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="{{ URL::to('post/'.$post->slug) }}" class="btn btn-success btn-sm rounded-0" data-placement="top" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                    </li>
                    <li class="list-inline-item">
                        <form action="{{ URL::to('delete/'.$post->slug) }}" method="POST">
                            @csrf
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger btn-sm rounded-0" data-placement="top" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @endforeach

    <div class="well">
        {{ $posts->links() }}
    </div>
@endsection