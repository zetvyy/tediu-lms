<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Update Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden p-10 shadow-sm sm:rounded-lg">

                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="py-3 w-full rounded-3xl bg-red-500 text-white">
                            {{$error}}
                        </div>
                    @endforeach
                @endif
                
                <form method="POST" action="{{route('admin.categories.update', $category)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input value="{{$category->name}}" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <img src="{{Storage::url($category->icon)}}" alt="{{$category->name}}" class="rounded-2xl object-cover w-[90px] h-[90px]">
                        <x-input-label for="icon" :value="__('icon')" />
                        <x-text-input id="icon" class="block mt-1 w-full" type="file" name="icon"  autofocus autocomplete="icon" />
                        <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                            
                    </div>

                    <div class="flex items-center justify-end mt-4">
            
                        <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Update Category
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
