@extends('layouts.app')

@section('content')
<div class="container-fluid position-relative mt-4">
    <div id="greet" role="alert" class="alert alert-primary position-absolute top-0 start-50 translate-middle border invisible rounded w-25 shadow text-center" style="z-index: 100">
        <p id="greetText" class="fw-semibold"></p>
    </div>
        <div class="row justify-content-center mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Chat with {{$friend->name}}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row p-2">
                            <div class="col-12">
                                <div class="row">
                                    <div  id="messages" class=" border rounded bg-secondary p-3 overflow-auto" style="height: 60vh" >
                                        {{-- CHAT --}}
                                    </div>
                                </div>
                                <form action="">
                                    <div class="row py-3">
                                        <div class="col-10">
                                            <input type="text" class="form-control" id="message">
                                        </div>
                                        <div class="col-2">
                                            <button id="send" class="btn btn-primary btn-block" type="submit">Enviar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="module">
    const sentElement = document.getElementById('send');
    const messageElement = document.getElementById('message');
    const friend = '{{$friend->id}}'; 
    const chatbox = document.getElementById('messages');
    sentElement.addEventListener('click',(e)=>{
        e.preventDefault();
        window.axios.post(`/chat/private/message/${friend}`,{
            message: messageElement.value
        });
        const mensaje = document.createElement('p');
        mensaje.classList.add('text-white')
        let span = document.createElement('span');
        span.classList.add('text-warning');
        span.innerHTML = `Tu > ${messageElement.value}`;
        mensaje.appendChild(span);
        chatbox.appendChild(mensaje);
        messageElement.value = "";
    })

</script>
<script type="module">
        const chatbox = document.getElementById('messages');
        const friend = '{{$friend->name}}'
    window.Echo.private('private.chat.{{auth::user()->id}}')
        .listen('PrivateChat',(e)=>{
            console.log(e.message);
            const currentUser = '{{auth::user()->id}}';
                const mensaje = document.createElement('p');
                mensaje.classList.add('text-white')
                mensaje.innerHTML = `${friend} > ${e.message}`;
                mensaje.setAttribute('id',e.user.id);
                
                chatbox.appendChild(mensaje);
        })
</script>
@endpush