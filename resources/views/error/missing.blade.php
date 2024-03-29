@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $code ?? 404 }}</div>
                    <div class="panel-body">
                        {!! $message ?? "Page not found or cannot be displayed." !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection