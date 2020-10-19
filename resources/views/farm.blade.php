@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">Character</th>
                                <th>Account</th>
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
                                    <td>{{ $character->name }}</td>
                                    <td>{{ $character->owner }}</td>
                                    <td>{{ $character->extractors() }}</td>
                                    <td>{{ $character->skillpoints() }}</td>
                                    <td>{{ $character->skillpointsMin() }}</td>
                                    <td>{{ $character->extractable() }}</td>
                                    <td><a href="#">Edit</a><a href="#">Remove</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
