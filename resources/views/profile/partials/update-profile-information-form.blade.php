<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information, username, email, password, and profile picture.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profileUpdate') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- First Name -->
        <div>
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full"
                :value="old('first_name', $user->first_name)" required autofocus autocomplete="first_name" />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        <!-- Last Name -->
        <div>
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                :value="old('last_name', $user->last_name)" required autocomplete="last_name" />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        <!-- Middle Name -->
        <div>
            <x-input-label for="middle_name" :value="__('Middle Name')" />
            <x-text-input id="middle_name" name="middle_name" type="text" class="mt-1 block w-full"
                :value="old('middle_name', $user->middle_name)" autocomplete="middle_name" />
            <x-input-error class="mt-2" :messages="$errors->get('middle_name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full"
                :value="old('username', $user->username)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <!-- Profile Image -->
        <div>
            <x-input-label for="image" :value="__('Profile Image')" />
            <input id="image" name="image" type="file" accept="image/*"
                class="mt-1 block w-full" onchange="previewImage(event)" />
            <x-input-error class="mt-2" :messages="$errors->get('image')" />

            <div class="mt-2">
                <img id="imagePreview"
                    src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/default-user.png') }}"
                    alt="Profile Preview"
                    style="height: 100px; width: 100px; border: 1px solid black; border-radius: 100%; object-fit: contain; background-color: black;">
            </div>
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status'))
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-gray-600">
                    {{ session('status') }}
                </p>
            @endif
        </div>
    </form>
</section>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
