@extends('layouts.app')

@push('styles')
<style>

</style>
@endpush

@section('content')
    <div class="container-fluid ">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Global Room 🌎</h2>
                    </div>
                    <div class="card-body">
                        <div class="row p-2">
                            <div class="col-10">
                                <div class="row">
                                    <div  id="messages" class=" border rounded bg-secondary p-3 overflow-auto" style="height: 60vh" >
                                        
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
                            <div class="col-2">
                                <p class="fs-4"><strong>Online now</strong></p>
                                <ul id="usersOnline" class="list-unstyled overflow-auto text-info" style="height: 45vh">

                                </ul>
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
    const usersElement = document.getElementById('usersOnline');
    const chatbox = document.getElementById('messages');
    
    window.Echo.join('chat')
    .here((users)=>{
        users.forEach((user,index) => {
                let element = document.createElement('li');
                let icon = document.createElement('small');
                icon.innerText = '🟢';
                icon.classList.add('mx-2');


                element.setAttribute('id',user.id);
                element.innerText = user.name ;
                element.appendChild(icon);
                usersElement.appendChild(element);
            });
        })
        .joining((user)=>{
            let element = document.createElement('li');
            let icon = document.createElement('small');
            icon.innerText = '🟢';
            icon.classList.add('mx-2');
          
            element.setAttribute('id',user.id);
            element.innerText = user.name ;
            element.appendChild(icon);
            usersElement.appendChild(element);

        })
        .leaving((user)=>{
            let element = document.getElementById(user.id);
                element.parentNode.removeChild(element);
        })
        .listen('MessageSent', (e)=>{
                const currentUser = '{{auth::user()->id}}';
                const mensaje = document.createElement('p');
                mensaje.classList.add('text-white')
                if(currentUser == e.user.id){
                    let span = document.createElement('span');
                    span.classList.add('text-warning');
                    span.innerHTML = `Tu > ${e.message}`;
                    
                    mensaje.appendChild(span);
                }else{
                
                    mensaje.innerHTML = `${e.user.name} > ${e.message}`;
                }
                mensaje.setAttribute('id',e.user.id);
                
                chatbox.appendChild(mensaje);
    
        })
</script>
<script type="module">
    const sentElement = document.getElementById('send');
    const messageElement = document.getElementById('message');

    sentElement.addEventListener('click',(e)=>{
        e.preventDefault();
        window.axios.post('/chat/message',{
            message: messageElement.value
        });

        messageElement.value = "";
    })

</script>
@endpush