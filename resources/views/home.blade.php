@extends('layout.app')

@section('content')
    <div class="container">
        <table class="table">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phones</th>
                <th>Emails</th>
                <th>Control</th>

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
                    <td>
                        <a href="{{ route('contact.show',[$contact]) }}" class="btn btn-sm btn-primary ml-3">Show</a>
                        <a href="{{ route('contact.edit',[$contact]) }}" class="btn btn-sm ml-3 btn-secondary">Update</a>
                        <a href="{{ route('contact.destroy',[$contact]) }}" class="btn btn-sm btn-danger ml-3">Delete</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
