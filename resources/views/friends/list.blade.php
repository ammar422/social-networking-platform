@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('My Friends') }}
                        </h2>
                        @foreach ($friends as $friend)
                            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    <span>
                                        <strong>
                                            {{ $friend->name }}
                                        </strong>
                                    </span>

                                    <div>
                                        <img width="100" height="100" src=" {{ $friend->profile->photo }}"
                                            alt="profile photo">
                                        <br>

                                        <form action="{{ route('profile.show', $friend->id) }}" method="get">
                                            @csrf
                                            <x-danger-button>{{ __('Visit') }}</x-danger-button>
                                        </form>


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
