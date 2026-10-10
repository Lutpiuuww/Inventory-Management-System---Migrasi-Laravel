@extends('layouts.app')

@section('title', 'Login - Inventory Manager')

@section('content')
<div class="form-container" style="margin-top: 100px;">
    <h2 style="margin-bottom: 24px; text-align: center;">Login to System</h2>
    
    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>
            @error('username')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 1rem; margin-top: 12px;">Login</button>
    </form>
</div>
@endsection
