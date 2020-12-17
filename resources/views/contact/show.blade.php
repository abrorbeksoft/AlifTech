@extends('layout.app')

@section('style')
    <style>
        #img{
            border-radius: 50%;
            width: 50%;
            margin-top: -25%;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endsection

@section('content')
    <div class="container ">
        <div  class="col-md-7  mx-auto">
            <div style="margin-top: 180px"  class="card  shadow">
                <img id="img" src="{{ asset('storage') }}/{{ $contact->image->name ?? 'images/noimage.png' }}" alt="">

                <div class="card-body">

                    <form action="{{ route('image.update',[$contact->id]) }}" class="mb-3" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $contact->id }}">
                        @method('PUT')
                        <div class="input-group" >
                            <input name="image" placeholder="Image" type="file" class="form-control @error('image') is-invalid @enderror">
                            <button class="btn btn-primary " >Update</button>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card-title">
                                <h5 >
                                    {{ $contact->name }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('contact.update',[$contact]) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="input-group">
                                    <input name="name" placeholder="name" type="text" class="form-control @error('name') is-invalid @enderror">
                                    <button class="btn btn-primary " >Update</button>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="small ">Phone numbers</h5>
                            <form action="{{ route('number.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $contact->id }}">
                                <div class="input-group ">
                                    <input value="{{ old('number') }}" name="number" type="text" placeholder="** *** ** **" class="d-block form-control @error('number') is-invalid @enderror">
                                    <button class="input-group-text bg-primary text-white" >Add</button>
                                    @error('number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </form>
                            @foreach($contact->numbers()->where('active',1)->get() as $phone)
                                <div class="small mb-1">
                                    <a onclick="deleteNumber({{ $phone->id  }})" class="badge btn bg-danger" >delete</a> {{ $phone->name }}

                                    <form id="number{{ $phone->id }}" class="d-none" action="{{ route('number.destroy',[$phone]) }}" method="post" >
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            @endforeach

                        </div>
                        <div class="col-md-6">
                            <h5 class="small">Emails</h5>
                            <form  action="{{ route('email.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $contact->id }}">
                                <div class="input-group ">
                                    <input value="{{ old('email') }}" name="email" type="email" placeholder="email" class="d-block form-control @error('email') is-invalid @enderror">
                                    <button class="input-group-text bg-primary text-white" >Add</button>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </form>
                            @foreach($contact->emails()->where('active',1)->get() as $email)
                                <div class="small mb-1">
                                    <a onclick="deleteEmail({{ $email->id }})" class="badge btn bg-danger " >delete</a>  {{ $email->name }}
                                    <form id="email{{ $email->id }}" class="d-none" action="{{ route('email.destroy',[$email]) }}" method="post" >
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        function deleteEmail(id)
        {
            console.log(id);
            document.getElementById('email'+id).submit();
        }
        function deleteNumber(id)
        {
            console.log(id)
            document.getElementById('number'+id).submit();
        }

    </script>
@endsection

