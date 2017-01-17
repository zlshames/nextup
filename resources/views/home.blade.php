@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3 style="text-align: center;">Upcoming Events</h3>
            <br />
            @foreach ($dates as $date)
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $date }}</div>

                    <div class="panel-body">
                        No events are scheduled for today
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
