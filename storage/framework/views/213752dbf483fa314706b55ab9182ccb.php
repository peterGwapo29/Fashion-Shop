<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile Dashboard</title>
<link rel="stylesheet" href="<?php echo e(asset('css/user.css')); ?>">
</head>
<body>

<div class="container">

    <!-- Header -->
    <div class="header">
        <h1>Profile</h1>
    </div>

    <!-- Profile Card -->
    <div class="card profile-card">
        <?php if(Auth::user()->image): ?>
            <a href="<?php echo e(route('user.page')); ?>">
                <img src="<?php echo e(asset('storage/' . Auth::user()->image)); ?>" 
                     alt="Profile" 
                     class="profile-img">
            </a>
        <?php endif; ?>
        <h2><?php echo e(Auth::user()->first_name); ?> <?php echo e(Auth::user()->middle_name); ?> <?php echo e(Auth::user()->last_name); ?></h2>
        <p class="premium">User Profile</p>
    </div>

    <!-- Account Details Form -->
    <div class="card bio-card">
        <h3>Account Details</h3>

        <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>

            <div class="details-grid">
                <div>
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" 
                           value="<?php echo e(old('first_name', Auth::user()->first_name)); ?>">
                </div>
                <div>
                    <label for="middle_name">Middle Name</label>
                    <input type="text" name="middle_name" id="middle_name" 
                           value="<?php echo e(old('middle_name', Auth::user()->middle_name)); ?>">
                </div>
                <div>
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" 
                           value="<?php echo e(old('last_name', Auth::user()->last_name)); ?>">
                </div>
                <div>
                    <label for="contact_number">Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" 
                           value="<?php echo e(old('contact_number', Auth::user()->contact_number)); ?>">
                </div>
                <div>
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" 
                           value="<?php echo e(old('address', Auth::user()->address)); ?>">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" 
                           value="<?php echo e(old('email', Auth::user()->email)); ?>">
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
        <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span style="color:red;"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
        <label for="new_password">New Password</label>
        <input type="password" name="new_password" id="new_password" placeholder="••••••••">
        <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span style="color:red;"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
        <label for="new_password_confirmation">Confirm Password</label>
        <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="••••••••">
        <span id="password-error" style="color:red; font-size:0.9rem;"></span>
    </div>
</div>


            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <a href="<?php echo e(route('welcome')); ?>">
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

<?php if(session('status')): ?>
<script>
Swal.fire({
    position: "center",
    icon: "success",
    title: "<?php echo e(session('status')); ?>",
    showConfirmButton: false,
    timer: 1500
});
</script>
<?php endif; ?>


</body>
</html>
<?php /**PATH C:\petergwapo\Taghoy\BSIT-3A-IPT2\Taghoy-Laravel-Homepage-User\resources\views/User/user.blade.php ENDPATH**/ ?>