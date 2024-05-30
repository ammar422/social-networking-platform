@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <strong>
                            {{ __('Create Post') }}
                        </strong>
                    </header>
                    <br><br><br>
                    <form action="{{ route('post.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <strong><label for="content">Content</label></strong>
                            <br>
                            <textarea id="content" name="content" cols="30" rows="5" required></textarea>
                        </div>
                        <br>
                        <x-success-button>{{ __('Submit') }}</x-danger-button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
