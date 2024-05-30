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
                                <br>
                                @can('update', $post)
                                    <form action="{{ route('post.edit', $post) }}" method="get" style="display:inline;">
                                        @csrf
                                        <x-success-button>
                                            {{ __('Edit') }}
                                            </x-danger-button>

                                    </form>
                                @endcan
                                @can('delete', $post)
                                    <form action="{{ route('post.destroy', $post) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button>{{ __('Delete') }}</x-danger-button>
                                    </form>
                                @endcan
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

                                <form action="{{ route('post.like', $post) }}" method="POST">
                                    @csrf
                                    <x-primary-button>{{ __('Like') }}</x-primary-button>

                                </form>
                                @if ($post->likes->count() > 0)
                                    <span>
                                        likes number : {{ $post->likes->count() }}
                                    </span>
                                @else
                                    <span>
                                        likes number : 0
                                    </span>
                                @endif

                                <form action="{{ route('post.comment', $post) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <x-text-input id="content" name="content" type="text" class="mt-1 block w-full"
                                            required autofocus placeholder="Add a comment..." />
                                        <x-success-button>{{ __('Comment') }}</x-success-button>
                                    </div>
                                </form>
                                @if ($post->comments->count() > 0)
                                    <span>
                                        comments number : {{ $post->comments->count() }}
                                    </span>
                                @else
                                    <span>
                                        comments number : 0
                                    </span>
                                @endif

                                <br>

                                <div class="mt-2">
                                    <x-input-label :value="__('Comments')" />
                                    @foreach ($post->comments as $comment)
                                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                            <div class="max-w-xl">
                                                <strong> {{ 'created at : ' }}</strong>
                                                {{ $comment->created_at->diffForHumans() }}
                                                </p>
                                                <strong>
                                                    {{ $comment->user->name }}
                                                </strong>: {{ $comment->content }}
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <hr>
                        <hr>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
