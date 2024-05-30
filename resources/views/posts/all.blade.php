@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <strong>
                            {{ __('All Posts') }}
                        </strong>
                    </header>
                    <br><br><br>
                    @foreach ($posts as $post)
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                <p>
                                    <strong> {{ 'author\'s name : ' }}</strong> {{ $post->user->name }}
                                    <br>
                                    <strong> {{ 'created at : ' }}</strong> {{ $post->created_at->diffForHumans() }}
                                </p>
                                <p>
                                    <strong> {{ 'author\'s photo : ' }}</strong> <img height="50" width="50"
                                        src="{{ $post->user->profile->photo }}" alt="profile photo">
                                </p>
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                        <div class="max-w-xl">
                                            <strong>
                                                {{ $post->content }}
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                                <br>


                                <form action="{{ route('post.edit', $post) }}" method="get" style="display:inline;">
                                    @csrf
                                    <x-success-button>{{ __('Edit') }}</x-danger-button>
                                </form>
                                <form action="{{ route('post.destroy', $post) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>{{ __('Delete') }}</x-danger-button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
