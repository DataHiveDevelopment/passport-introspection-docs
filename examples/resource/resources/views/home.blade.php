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

                    You are logged in! Welcome, {{ Auth::user()->name }}!
                </div>
            </div>
        </div>
    </div>

    <div class="row my-2">
        <div class="col">
            <div class="card">
                <div class="card-header">API Tests</div>

                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-4">
                            {{ config('services.oauth.base_url') }}/api/user
                        </div>
                        <div class="col">
                            <textarea rows="5" class="form-control" onfocus="this.select();" readonly>{{ $authApiUser }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            {{ config('app.url') }}/api/user
                        </div>
                        <div class="col">
                            <textarea rows="5" class="form-control" onfocus="this.select();" readonly>{{ $appApiUser }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-2">
        <div class="col">
            <div class="card">
                <div class="card-header">Token Details</div>

                <div class="card-body">
                    <div class="form-group row">
                        <div class="col">
                            <div class="btn-toolbar" role="toolbar" aria-label="Token actions toolbar">
                                <a href="{{ route('example.refresh') }}" class="btn btn-primary">Refresh</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            Token:
                        </div>
                        <div class="col">
                            <textarea class="form-control" rows="5" onfocus="this.select();" readonly>{{ Auth::user()->access_token }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            Refresh:
                        </div>
                        <div class="col">
                            <textarea class="form-control" rows="5" onfocus="this.select();" readonly>{{ Auth::user()->refresh_token }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            Expires At (In seconds):
                        </div>
                        <div class="col">
                            {{ Auth::user()->expires_at }} ({{ Auth::user()->expires_at->diffForHumans() }})
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
