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
                            {{ config('app.url') }}/api/examples/user
                        </div>
                        <div class="col">
                            <textarea rows="5" class="form-control" onfocus="this.select();" readonly>{{ $appApiUser }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            (Axios Javscript Request, non-scoped) {{ config('app.url') }}/api/examples/notifications
                        </div>
                        <div class="col">
                            <api-component :url="'/api/examples/notifications'"></api-component>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            (Axios Javscript Request, scoped) {{ config('app.url') }}/api/examples/messages
                        </div>
                        <div class="col">
                            <api-component :url="'/api/examples/messages'"></api-component>
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
                            Access Token Claims
                        </div>
                        <div class="col">
                            <ul>
                                @foreach($token->getClaims() as $claim)
                                <li>{{ $claim->getName() }}: {{ is_array($claim->getValue()) ? implode(' ', $claim->getValue()) : $claim->getValue() }}</li>
                                @endforeach
                            </ul>
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

                    <div class="form-group row">
                        <div class="col-md-4">
                            Scopes:
                        </div>
                        <div class="col">
                            <textarea class="form-control" rows="5" onfocus="this.select();" readonly>{{ implode(' ', $token->getClaim('scopes')) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
