@php
use Illuminate\Support\Facades\Storage;
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-500 leading-tight">
                {{ __('Manage Hotels') }}
            </h2>
            <a href="{{ route('admin.hotels.create') }}" class="font-bold py-4 px-6 bg-indigo-700 text-slate-500  rounded-full">
                Add New
            </a>
        </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5" style="padding: 22px; gap: 9px 2px;">

            @forelse($hotels as $hotel)
                <div class="item-card flex flex-row justify-between items-center">
                    <div class="flex flex-row items-center gap-x-3">
                        <img src="{{ url(Storage::url($hotel->thumbnail)) }}" alt="" class="rounded-2xl object-cover w-[120px] h-[90px]" style="width: 120px; height: 90px;" />
                        <div class="flex flex-col">
                            <h3 class="text-indigo-950 text-xl font-bold">
                                {{$hotel->name}}
                            </h3>
                        <p class="text-slate-500 text-sm">
                            {{$hotel->city->name}},  {{$hotel->country->name}}
                        </p>
                        </div>
                    </div> 
                    <div  class="md:flex flex-col">
                        <p class="text-slate-500 text-sm">Price</p>
                        <h3 class="text-indigo-950 text-xl font-bold">
                            Rp {{ number_format($hotel->getlowestRoomPrice(), 0, ',', '.') }}/night
                        </h3>
                    </div>
                    <div class="md:flex flex-row items-center gap-x-3">
                        <a href="{{ route('admin.hotels.show', $hotel) }}" class="font-bold py-4 px-6 bg-indigo-700 text-slate-500 rounded-full">
                            Manage
                        </a>
                    </div>
                </div> 
                @empty
                    <div>
                        <h5>datanya belum ada</h5>
                    </div>
                @endforelse


            </div>
        </div>
    </div>
</x-app-layout>
