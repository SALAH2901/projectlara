<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Photo -->
        <div>
            <x-input-label for="photo" :value="__('Profile Photo')" />
            <div class="mt-2 flex items-center gap-4">
                @if($user->profile_photo_path)
                    <img src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}" class="h-16 w-16 rounded-full object-cover border border-gray-200">
                @else
                    <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xl border border-indigo-200">
                        {{ substr($user->first_name, 0, 1) }}{{ substr($user->name, 0, 1) }}
                    </div>
                @endif
                <input id="photo" name="photo" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/jpeg,image/png,image/jpg" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required autofocus autocomplete="first_name" />
                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>

            <div>
                <x-input-label for="name" :value="__('Last Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if($user->role === 'doctor')
            <div class="border-t border-gray-200 pt-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Doctor Profile Details</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <x-input-label for="specialization" :value="__('Specialization')" />
                        <x-text-input id="specialization" name="specialization" type="text" class="mt-1 block w-full" :value="old('specialization', optional($user->doctorProfile)->specialization)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('specialization')" />
                    </div>

                    <div>
                        <x-input-label for="consultation_fee" :value="__('Consultation Fee ($)')" />
                        <x-text-input id="consultation_fee" name="consultation_fee" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('consultation_fee', optional($user->doctorProfile)->consultation_fee)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('consultation_fee')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="biography" :value="__('Biography')" />
                    <textarea id="biography" name="biography" rows="4" class="mt-1 block w-full bg-white/50 border-white/50 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm backdrop-blur-sm transition duration-150">{{ old('biography', optional($user->doctorProfile)->biography) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('biography')" />
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
