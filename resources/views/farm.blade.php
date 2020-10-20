@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-dark table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th colspan="2">Character</th>
                        <th>Account tag</th>
                        <th>Paid until</th>
                        <th>Extractors</th>
                        <th>SP Total</th>
                        <th>SP min.</th>
                        <th>SP Extractable</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($characters as $character)
                        <tr id="character{{ $character->id }}">
                            <td><img src="https://images.evetech.net/characters/{{ $character->id }}/portrait?tenant=tranquility&size=32" width="32" height="32" alt="{{ $character->name }}"></td>
                            <td><input type="text" value="{{ $character->name }}" readonly></td>
                            <td><input type="text" value="{{ $character->account }}"></td>
                            <td><input type="date" value="{{ $character->paid_until }}"></td>
                            <td>{{ $character->extractors() }}</td>
                            <td>{{ $character->skillpoints_total }}</td>
                            <td><input type="number" value="{{ $character->skillpoints_min }}" min="5500000" step="100000"></td>
                            <td>{{ $character->extractable() }}</td>
                            <td><a href="#">Edit</a><a href="#">Remove</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
