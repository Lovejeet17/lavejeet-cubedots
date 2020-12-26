@extends('layouts.posts')

@section('content')

    <h4>All Posts</h4>
    @foreach ($posts as $post)
    <div class="well">
        <div class="media">
            <a class="pull-left" href="#">
              <img class="media-object" src="{{ $post->featured_image }}">
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
@endsection