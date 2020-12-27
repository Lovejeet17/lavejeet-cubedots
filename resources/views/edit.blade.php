@extends('layouts.posts')

@section('content')
<div class="row">
	    
    <div class="col-md-8 col-md-offset-2">

        @if(empty($post))
            <h1>Create post</h1>
        @else
            <h1>Edit post</h1>
        @endif
        
        <form action="{{ URL::to('/store') }}" method="POST" enctype="multipart/form-data">

            @csrf
            
            <div class="form-group">
                <label for="slug">Slug <span class="require">*</span> <small>(This field use in url path.)</small></label>
                <input type="text" class="form-control" name="slug" value="@isset($post->slug){{ $post->slug }}@endisset"/>
                <span class="help-block">Field not entered!</span>
            </div>
            
            <div class="form-group">
                <label for="title">Title <span class="require">*</span></label>
                <input type="text" class="form-control" name="title" value="@isset($post->title){{ $post->title }}@endisset"/>
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <p>Enter comma saperated tags for use more than one</p>
                <input type="text" class="form-control" name="tags"/>
            </div>

            <div class="form-group">
                @if ($post->featured_image)
                <img class="media-object" src="{{ '/storage/thumbnails/'.$post->featured_image }}">
                @endif
                <label for="featured_image">Upload Featured Image</label>
                <input type="file" class="form-control-file" name="featured_image" />
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea rows="5" class="form-control" name="description" >@isset($post->description){{ $post->description }}@endisset</textarea>
            </div>
            
            <div class="form-group">
                <p><span class="require">*</span> - required fields</p>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Create
                </button>
                <button class="btn btn-default">
                    Cancel
                </button>
            </div>
            
        </form>
    </div>
    
</div>
@endsection