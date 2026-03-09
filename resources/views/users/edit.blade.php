@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">Edit User</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user) }}" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password (leave blank to keep unchanged)</label>

                            <div class="input-group">
                                <input type="password" autocomplete="off" name="password" id="password" class="form-control">

                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>

                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>

                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">

                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password_confirmation">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update User</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Password Toggle Script -->
<script>
document.querySelectorAll('.toggle-password').forEach(button => {

    button.addEventListener('click', function () {

        const target = document.getElementById(this.dataset.target);
        const icon = this.querySelector('i');

        const type = target.getAttribute('type') === 'password' ? 'text' : 'password';
        target.setAttribute('type', type);

        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');

    });

});
</script>

@endsection