@extends('layouts.app')

@section('main')
<div class="row row-sm justify-content-center">
    <div class="col align-self-center col-lg-5">
        <div class="card">
            <div class="card-body">
                <h4>Profile</h4>

                <form method="POST" action="{{ route('update-profile') }}">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('Name') }}</label>
                        <input type="text" class="form-control" placeholder="Enter your name" type="text" name="name" value="{{ $user->name }}" required>
                    </div><!-- form-group -->
                    <div class="form-group">
                        <label>{{ __('Email') }}</label>
                        <input type="text" class="form-control" placeholder="Enter your email" type="email" name="email" value="{{ $user->email }}" required>
                    </div><!-- form-group -->
                    
                    <div class="form-group">
                        <label>{{ __('New Password') }}</label>
                        <input type="password" class="form-control" placeholder="Enter new password"
                                    name="password"
                                    required autocomplete="current-password">
                    </div><!-- form-group -->
                    <div class="form-group">
                        <label>{{ __('Confirm') }}</label>
                        <input type="password" class="form-control" placeholder="Confirm password"
                                    name="password_confirmation"
                                    required autocomplete="current-password">
                    </div><!-- form-group -->
                    <button class="btn btn-primary btn-block">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection