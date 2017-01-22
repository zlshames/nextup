@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (!$single)
              <h3 style="text-align: center;">Categories</h3>
              <br />
              @foreach ($categories as $cat)
                  <div class="panel panel-default">
                      <div class="panel-body">
                          <a href="/categories/{{ $cat->id }}">{{ $cat->name }}</a>
                      </div>
                  </div>
              @endforeach
            @else
              <h3 style="text-align: center;">{{ $category->name }}</h3>
            @endif
        </div>
    </div>
</div>
@endsection
