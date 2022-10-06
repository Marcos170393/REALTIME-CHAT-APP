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
                        <h2>Chat</h2>
                    </div>
                    <div class="card-body">
                        <div class="row p-2">
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-12 border rounded-lg p-3">
                                        <ul id="messages" class="list-unstyled overflow-auto" style="height:45vh">

                                        </ul>
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
                                <p><strong>Online now</strong></p>
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
@endpush