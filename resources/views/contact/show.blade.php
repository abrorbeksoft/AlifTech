@extends('layout.app')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <div class="card-title">
                    {{ $contact->name }}
                </div>
            </div>
        </div>
    </div>

@endsection
