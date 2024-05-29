@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Friends requests') }}
                        </h2>
                        @foreach (Auth::user()->friendRequests as $request)
                            <div class="py-6">
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                        <div class="max-w-xl">
                                            <span>
                                                <strong>
                                                    {{ $request->user->name }} wants to be your friend.
                                                </strong>
                                            </span>
                                            <div>
                                                <img width="100" height="100" src="{{ $request->user->profile->photo }}"
                                                    alt="profile photo">
                                                <br>
                                                <form action="{{ route('accept.request', $request->id) }}" method="POST"
                                                    class="mt-6 space-y-6">
                                                    @csrf
                                                    <x-primary-button>{{ __('Accept') }}</x-primary-button>
                                                </form>
                                                <form action="{{ route('reject.request', $request->id) }}" method="POST"
                                                    class="mt-6 space-y-6">
                                                    @csrf
                                                    <x-danger-button>{{ __('Reject') }}</x-danger-button>
                                                </form>
                                            </div>
                                        </div>
                                        <br><br>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </header>
                </div>
            </div>
        </div>
    </div>
@endsection
