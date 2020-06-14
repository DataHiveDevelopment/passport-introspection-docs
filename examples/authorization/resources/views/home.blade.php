@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-2">
        <div class="col">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>

    <div class="row my-2">
        <div class="col">
            <passport-clients></passport-clients>
        </div>
    </div>

    <div class="row my-2">
        <div class="col">
            <passport-authorized-clients></passport-authorized-clients>
        </div>
    </div>

    <div class="row my-2">
        <div class="col">
            <passport-personal-access-tokens></passport-personal-access-tokens>
        </div>
    </div>
</div>
@endsection
