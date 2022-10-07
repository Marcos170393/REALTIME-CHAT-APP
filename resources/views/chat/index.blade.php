@extends('layouts.app')

@push('styles')
<style>
    #usersOnline > li {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="container-fluid position-relative mt-4">
    <div id="greet" role="alert" class="alert alert-primary position-absolute top-0 start-50 translate-middle border invisible rounded w-25 shadow text-center" style="z-index: 100">
        <p id="greetText" class="fw-semibold"></p>
    </div>
        <div class="row justify-content-center mt-5">
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
                            <div class="col-2">
                                <p class="fs-4"><strong>Online now</strong></p>
                                <ul id="usersOnline" class="list-unstyled overflow-auto text-info" style="height: 45vh">
                                    {{-- USUARIOS CONECTADOS --}}
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
                    addUser(user);
                });
            })
        .joining((user)=>{
            addUser(user);
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
        function addUser(user){
            let element = document.createElement('li');
            let textName = document.createElement('p');
            let icon = document.createElement('small');
            icon.innerText = '📧';
            icon.classList.add('mx-2');


            if(user.id != {{auth::user()->id}}){
                textName.setAttribute('onclick','greetUser("'+ user.id +'")');
                }
            textName.innerText = user.name ;
            element.classList.add('d-flex');
            element.appendChild(textName);
            element.appendChild(icon);
            usersElement.appendChild(element);
        }
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
<script type="module">
    window.Echo.private('chat.greet.{{auth::user()->id}}')
        .listen('GreetingSent',(e)=>{
            document.getElementById('greet').classList.remove('invisible');
            document.getElementById("greetText").innerText = `${e.message} 👋`;
            setTimeout(() => {
                document.getElementById('greet').classList.add('invisible');
            }, 5000);
            
        })
</script>
<script>
    function greetUser(id){
        window.axios.get('/chat/greet/'+id);
    }
    //TODO Completar metodo que abra un canal con el usuario solicitado,
    // Puede abrir una ventana de chat pequeña o algo asi, tendria que funcionar igual que con el chat general pero de modo privado para el usuario implicado
    function privateChat(id){
    }
</script>
@endpush