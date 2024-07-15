<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-indigo-950 leading-tight">
                {{ __('Manage Cities') }}
            </h2>
            <a href="{{ route('admin.cities.create') }}" class="font-bold py-4 px-6 bg-indigo-700 text-indigo-950 rounded-full">
                Add New
            </a>
        </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5" style="padding: 22px; gap: 9px 2px;">
 
                @forelse($cities as $city)
                <div class="item-card flex flex-row justify-between items-center">
                    <div class="flex flex-row items-center gap-x-3">
                        <div class="flex flex-col">
                            <p class="text-slate-500 text-sm">Name</p>
                            <h3 class="text-indigo-950 text-xl font-bold">
                                {{ $city->name }}
                            </h3>
                        </div>
                    </div> 
                    <div  class=" md:flex flex-col">
                        <p class="text-slate-500 text-sm">Date</p>
                        <h3 class="text-indigo-950 text-xl font-bold">
                            {{ $city->created_at->format('M d, Y') }}
                        </h3>
                    </div>
                    <div class="flex md:flex flex-row items-center gap-x-3" style="gap: 10px;">
                        <a href="{{route('admin.cities.edit', $city)}}" class="font-bold py-4 px-6 bg-indigo-700 text-indigo-950 rounded-full" style="background-color: blueviolet;">
                            Edit
                        </a>
                        <form action="{{ route('admin.cities.destroy', $city) }}" method="POST"> 
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-bold py-4 px-6 bg-red-700 text-indigo-950 rounded-full" style="background-color: red;">
                                Delete
                            </button>
                        </form>
                    </div>
                </div> 
                @empty
                    <div>
                        <h5>datanya belum ada</h5>
                    </div>
                @endforelse

                {{$cities->Links()}}

            </div>
        </div>
    </div>
</x-app-layout>
