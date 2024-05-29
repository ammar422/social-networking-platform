<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name. ' Profile' }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Profile photo') }}
                        </h2>

                        @if (auth()->user()->profile->photo)
                            <img src= "{{ $user->profile->photo }}" alt="profile photo" height="400"
                                width="400">
                        @endif
                    </header>
                </div>
            </div>
        </div>
        <br><br>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Profile Information') }}
                    </h2>
                    <br>
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <span>
                            <p>
                                <strong>
                                    {{ $user->name }}
                                </strong>
                            </p>
                        </span>
                    </div>
                    <br>
                    <div>
                        <x-input-label for="email" :value="__('email')" />
                        <span>
                            <p>
                                <strong>
                                    {{ $user->email }}
                                </strong>
                            </p>
                        </span>
                    </div>
                    <br>
                    <div>
                        <x-input-label for="bio" :value="__('bio')" />
                        <span>
                            <p>
                                <strong>
                                    {{ $user->profile->bio }}
                                </strong>
                            </p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
<br><br>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('your Posts') }}
                    </h2>
                    <br>
                    @isset ($posts)
                        @foreach ($posts as $post)
                        <div>
                           <label for="post"> {{ $post->created_at }}</label>
                            <span>
                                <p>
                                        {{ $post->body }}                                
                                </p>
                            </span>
                        </div>
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>
    </div>



</x-app-layout>
