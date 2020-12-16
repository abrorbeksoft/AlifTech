@extends('layout.app')

@section('content')
    <div class="container">
        <table class="table">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phones</th>
                <th>Emails</th>
            </tr>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $loop->index }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>
                        @foreach($contact->numbers as $number)
                            <div>
                                {{ $number->name ?? '' }}
                            </div>
                        @endforeach
                    </td>
                    <td>
                        @foreach($contact->emails as $email)
                            <div>
                                {{ $email->name ?? '' }}
                            </div>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
