@extends('layout.app')

@section('content')
    <div class="container">
        <div class="col-md-10 mx-auto">
            <div class="my-3">
                <a class="btn btn-primary" href="{{ route('contact.create') }}">Add Contact</a>
            </div>
        </div>
        @foreach($contacts as $contact)
            <div class="col-md-10 mt-3 shadow  mx-auto">
                <div class="card mb-3 " >
                    <div class="row g-0">
                        <div class="m-3" style="width: 60px;  height: 60px" >
                            <img  class="w-100 rounded rounded-circle" src="{{ asset('storage/') }}/{{ $contact->image->name ?? 'images/noimage.png'  }}" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h4 class="card-title">{{ $contact->name }}</h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="card-title small">Emails</h6>
                                        @foreach($contact->emails as $email)
                                            <div class="text-muted small">
                                                {{ $email->name }}
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="card-title small">Phone Numbers</h6>
                                        @foreach($contact->numbers as $number)
                                            <div class="text-muted small">
                                                {{ $number->name }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="position-absolute   text-white  bottom-0 end-0">
                        <a style="cursor: pointer" onclick="submitForm({{ $contact->id }})"  class="p-1 text-decoration-none  bg-danger text-white  border-0 ">
                            Delete
                        </a>
{{--                        <a  href="{{ route('contact.edit',[$contact]) }}" class="text-white bg-secondary p-1 text-decoration-none">--}}
{{--                            Edit--}}
{{--                        </a>--}}

                        <a  href="{{ route('contact.show',[$contact]) }}" class="text-white bg-primary p-1 text-decoration-none">
                            Show
                        </a>

                        <form id="form{{ $contact->id }}" class="d-none" action="{{ route('contact.destroy',[$contact]) }} " method="post"  >
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-10 mx-auto">
            {{ $contacts->links() }}

        </div>
    </div>
@endsection

@section('script')
    <script>
        function submitForm(id) {

           document.getElementById('form'+id).submit();
        }
    </script>
@endsection

