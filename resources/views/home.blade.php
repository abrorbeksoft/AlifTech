@extends('layout.app')

@section('content')
    <div class="container">
        <div class="col-md-10 mx-auto">
            <div class="my-3">
                <a class="btn btn-primary" href="{{ route('contact.create') }}">Add Contact</a>
            </div>
            <div class="my-3">
                <table class="table">
                    <tr>
                        <td><input type="text" id="searchname" placeholder="search by name" class="form-control"></td>
                        <td><input type="text" id="searchnumber" placeholder="search by number" class="form-control"></td>
                        <td><input type="text" id="searchemail" placeholder="search by email " class="form-control"></td>
                    </tr>
                </table>
            </div>

        </div>
        <div id="list">
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
        </div>
        <div class="col-md-10 mx-auto">
            {{ $contacts->links() }}

        </div>
    </div>
@endsection

@section('script')
    <script>

        var inputname=document.getElementById('searchname')
        var inputnumber=document.getElementById('searchnumber')
        var inputemail=document.getElementById('searchemail')
        var list=document.getElementById('list')

        inputname.addEventListener('input',async function (){
            if (inputname.value!='')
                await axios.get(`api/name?q=${inputname.value}`).then(({data})=>{
                    // console.log(data);
                    if (data.length>0) pushElem(data)
                })
        })

        inputemail.addEventListener('input',async function (){
            if (inputemail.value!='')
                await axios.get(`api/email?q=${inputemail.value}`).then(({data})=>{
                    if (data.length>0) pushElem(data)
                })
        })

        inputnumber.addEventListener('input',async function (){

            if (inputnumber.value!='')
               await axios.get(`api/number?q=${inputnumber.value}`).then(({data})=>{
                   // console.log(data);

                   if (data.length>0) pushElem(data)
                })

        })

        function pushElem(data)
        {
            // console.log(data);
            var str='';
            list.innerHTML='';
            data.forEach(function (elem){
                str+=`<div class="col-md-10 mt-3 shadow  mx-auto">
                <div class="card mb-3 " >
                    <div class="row g-0">
                        <div class="m-3" style="width: 60px;  height: 60px" >
                            <img  class="w-100 rounded rounded-circle" src="${elem.image!=null?elem.image.name:'/storage/images/noimage.png'}" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h4 class="card-title">${elem.name}</h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="card-title small">Emails</h6>`;

                   elem.emails.forEach(function (email){
                       str+=`<div class="text-muted small">${email.name}</div>`
                   })

                str+=`</div><div class="col-md-6"><h6 class="card-title small">Phone Numbers</h6>`

                    elem.numbers.forEach(function (number){
                        str+=`<div class="text-muted small">${ number.name }</div>`
                    })


                str+=`</div></div></div></div></div><div class="position-absolute   text-white  bottom-0 end-0">
                <a style="cursor: pointer" onclick="submitForm(${ elem.id })"  class="p-1 text-decoration-none  bg-danger text-white  border-0 ">
                 Delete</a><a  href="contact/${elem.id}" class="text-white bg-primary p-1 text-decoration-none">Show</a>
                <form id="form${ elem.id }" class="d-none" action="contact/${elem.id} " method="post"  >
                 <input type="hidden" name="_token" value="0Xluo9sz6ZRIXasvFX9MOK6fMsvkjCFnS5LoNlHN">
                <input type="hidden" name="_method" value="DELETE"></form></div> </div></div>`
            })

            list.innerHTML=str;
        }


        function submitForm(id) {

           document.getElementById('form'+id).submit();
        }



    </script>
@endsection

