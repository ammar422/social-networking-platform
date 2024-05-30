<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'edit "' . auth()->user()->name . '" Post' }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">



            <form method="post" action="{{ route('post.update', $post->id) }}" class="mt-6 space-y-6">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="content" :value="__('Content')" />
                    <x-text-input id="content" name="content" type="text" class="mt-1 block w-full" :value="old('content', $post->content)"
                        required autofocus autocomplete="content" />
                    <x-input-error class="mt-2" :messages="$errors->get('content')" />
                </div>


                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </div>
            </form>



        </div>
    </div>
</x-app-layout>
