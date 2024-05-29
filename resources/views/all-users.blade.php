@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            <strong>
                                {{ __('Others') }}
                            </strong>
                        </h2>
                    </header>
                </div>
                <br><br>
            </div>
        </div>
    </div>
    @foreach (app\Models\User::get() as $user)
        @if ($user->id !== Auth::id())
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            <span>
                                <strong>
                                    {{ $user->name }}
                                </strong>
                            </span>
                            <div>
                                <img width="100" height="100" src=" {{ $user->profile->photo }}" alt="profile photo">
                                <br>
                                <form action="{{ route('send.request', $user->id) }}" method="POST" class="mt-6 space-y-6">
                                    @csrf
                                    <x-primary-button>{{ __('Add friend') }}</x-primary-button>
                                </form>

                            </div>
                        </div>
                        <br><br>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
