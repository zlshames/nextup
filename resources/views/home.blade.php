@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h3 style="text-align: center;">Upcoming Events</h3>
			<br />
			@for ($i = 0; $i < count($week); $i++)
				<div class="panel panel-default">
					<div class="panel-heading">{{ $week[$i][0] }}</div>
					@if (count($week[$i]) == 1)
						<div class="panel-body">
							No events scheduled today
						</div>
					@else
						@for ($y = 1; $y < count($week[$i]); $y++)
							<div class="panel-body">
								{{ json_decode($week[$i][$y])->name }}
							</div>
						@endfor
					@endif
				</div>
			@endfor
		</div>
	</div>
</div>
@endsection
