<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile photo') }}
        </h2>

        @if ($user->profile->photo)
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Update your profile photo.') }}
            </p>
        @else
            <p class="mt-1 text-sm text-gray-600">
                {{ __('upload your profile photo.') }}
            </p>
        @endif

        <form method="post" action="{{ route('profile.photo_upload') }}" class="mt-6 space-y-6"
            enctype="multipart/form-data">
            @csrf
            @if ($user->profile->photo)
                <img src= "{{ $user->profile->photo }}"
                    alt="profile photo">
            @endif
            <input type="file" name="photo" id="photo">
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>



    </header>



</section>
