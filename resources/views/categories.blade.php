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
                          <a href="/categories/{{ $cat }}">{{ $cat }}</a>
                      </div>
                  </div>
              @endforeach
            @else
							@if ($category !== null)
              	<h3 style="text-align: center;">{{ $category->name }}</h3>

								@for ($i = 0; $i < count($events); $i++)
									<div class="panel panel-default">
										<div class="panel-heading">{{ $events[$i]->start }}</div>
										<div class="panel-body">
											{{ $events[$i]->name }}
										</div>
									</div>
								@endfor
							@else
								<h3 style="text-align: center;">Category Not Found</h3>
							@endif
						@endif
        </div>
    </div>
</div>
@endsection
