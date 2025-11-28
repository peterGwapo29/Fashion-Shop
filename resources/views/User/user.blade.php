<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile Dashboard</title>
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>
<body>

<div class="container">

    <!-- Header -->
    <div class="header">
        <h1>Profile Information</h1>
    </div>

    <!-- Profile Card -->
    <div class="card profile-card">
        @if (Auth::user()->image)
            <a href="{{ route('user.page') }}">
                <img src="{{ asset('storage/' . Auth::user()->image) }}" 
                     alt="Profile" 
                     class="profile-img">
            </a>
        @endif
        <h2>{{ Auth::user()->first_name }} {{ Auth::user()->middle_name }} {{ Auth::user()->last_name }}</h2>
        <p class="premium">User Profile</p>
    </div>

    <!-- Account Details Form -->
    <div class="card bio-card">
        <h3>Account Details</h3>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="details-grid">
                <div>
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" 
                           value="{{ old('first_name', Auth::user()->first_name) }}">
                </div>
                <div>
                    <label for="middle_name">Middle Name</label>
                    <input type="text" name="middle_name" id="middle_name" 
                           value="{{ old('middle_name', Auth::user()->middle_name) }}">
                </div>
                <div>
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" 
                           value="{{ old('last_name', Auth::user()->last_name) }}">
                </div>
                <div>
                    <label for="contact_number">Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" 
                           value="{{ old('contact_number', Auth::user()->contact_number) }}">
                </div>
                <div>
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" 
                           value="{{ old('address', Auth::user()->address) }}">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email', Auth::user()->email) }}">
                </div>
                <div>
                    <label for="image">Profile Image</label>
                    <input type="file" name="image" id="image">
                </div>
            </div>

            <h3 style="margin-top:2rem;">Change Password</h3>
            <div class="password-change">
    <div>
        <label for="current_password">Current Password</label>
        <input type="password" name="current_password" id="current_password" placeholder="••••••••">
        @error('current_password')
            <span style="color:red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="new_password">New Password</label>
        <input type="password" name="new_password" id="new_password" placeholder="••••••••">
        @error('new_password')
            <span style="color:red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="new_password_confirmation">Confirm Password</label>
        <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="••••••••">
        <span id="password-error" style="color:red; font-size:0.9rem;"></span>
    </div>
</div>


            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <a href="{{ route('welcome') }}">
                    <button type="button" class="back-btn">Back</button>
                </a>
                <button type="submit" class="save-btn">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- SweetAlert2 JS -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelector("form").addEventListener("submit", function (e) {
    const newPassword = document.getElementById("new_password").value.trim();
    const confirmPassword = document.getElementById("new_password_confirmation").value.trim();
    const errorSpan = document.getElementById("password-error");

    errorSpan.textContent = "";
    document.getElementById("new_password").style.border = "";
    document.getElementById("new_password_confirmation").style.border = "";

    if (newPassword && confirmPassword && newPassword !== confirmPassword) {
        e.preventDefault();
        errorSpan.textContent = "Passwords do not match";
        document.getElementById("new_password").style.border = "1px solid red";
        document.getElementById("new_password_confirmation").style.border = "1px solid red";
    }
});
</script>

@if (session('status'))
<script>
Swal.fire({
    position: "center",
    icon: "success",
    title: "{{ session('status') }}",
    showConfirmButton: false,
    timer: 1500
});
</script>
@endif


</body>
</html>
