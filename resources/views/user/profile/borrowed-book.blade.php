@extends('layouts.show', ['routeDirect' => 'member.home'])

@section('content')
<section class="grid grid-cols-4 gap-16">
    <x-navigation.sidebar/>

    <div class="col-span-3 ">
        <div>
            <table class="min-w-full bg-white border  border-font/20 rounded-lg">
            <thead class="text-left text-sm text-gray-700 uppercase ">
                <tr>
                    <th class="px-6 py-3 bg-primary-300 text-white  font-normal ">#</th>
                    <th class="px-6 py-3 min-w-56 bg-primary-300 text-white  font-normal">Code</th>
                    <th class="px-6 py-3 min-w-52 bg-primary-300 text-white  font-normal">Book Title</th>
                    <th class="px-6 py-3 min-w-52 bg-primary-300 text-white  font-normal">Status</th>
                    <th class="px-6 py-3 min-w-24  bg-primary-300 text-white  font-normal"></th>
                </tr>
            </thead>
            <tbody class="text-font">
            @forelse ($borrowedBooks as $index => $borrowed)
                <div class="first:flex hidden justify-center items-center min-h-screen bg-black/50 fixed  inset-0">
                    <div class="w-[48%] min-h-[45vh] bg-white  rounded-xl p-6 grid grid-cols-3 gap-8">
                        <div class="col-span-1 p-4 rounded-xl shadow-sm bg-bgWidget h-full object-cover w-full">
                            <img src="{{ $borrowed->book->getFirstMediaUrl('book') }}" alt="" class="h-full w-full  rounded-xl">
                        </div>
                        <div class="col-span-2 pt-3 flex-col flex justify-between">
                            <div>
                                <div class="mb-3 pb-3 border-b border-font/20">
                                    <h2 class="text-lg mb-1.5">{{ $borrowed->book->title }}</h2>
                                    <p class="text-sm text-font/60">{{ $borrowed->book->category->name }}</p>
                                </div>
                                <div>
                                    <h3 class=" mb-2">Borrowed Detail</h3>
                                    <div class="flex flex-col gap-2">
                                        <div class="grid grid-cols-4 text-font/60 ">
                                            <h4 class="text-sm">Code</h4>
                                            <span class="text-sm text-center">:</span>
                                            <p class="col-span-2 text-sm text-end bg">{{ $borrowed->code }}</p>
                                        </div>
                                        <div class="grid grid-cols-4 text-font/60 ">
                                            <h4 class="text-sm">Borrowed Date</h4>
                                            <span class="text-sm text-center">:</span>
                                            <p class="col-span-2 text-sm text-end bg">{{ \Carbon\Carbon::parse($borrowed->borrowed_date)->format('d M Y') }}</p>
                                        </div>
                                        <div class="grid grid-cols-4 text-font/60 ">
                                            <h4 class="text-sm">Due Date</h4>
                                            <span class="text-sm text-center">:</span>
                                            <p class="col-span-2 text-sm text-end bg">{{ \Carbon\Carbon::parse($borrowed->due_date)->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between items-end">
                                <div class="flex flex-col">
                                    <span class="text-sm text-font/60">Status</span>
                                    <span class="capitalize rounded-lg
                                        {{ match ($borrowed->status) {
                                            'pending' => 'text-blue-500',
                                            'borrowed' => 'text-amber-500',
                                            'penalty' => 'text-red-500',
                                            'returned' => 'text-font/40'
                                        } }}
                                    ">{{ $borrowed->status }}</span>
                                </div>
                                <div class="flex gap-4 items-center">
                                    <button class="px-4 py-2 bg-bgWidget hover:bg-bgWidget/80 transition ease-in-out text-sm rounded-lg  font-normal">Close</button>
                                    <button class="px-4 py-2 bg-primary-300 hover:bg-primary-300/80 transition ease-in-out text-sm rounded-lg text-white font-normal">Return</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <tr class="border-t border-font/20 hover:bg-bgWidget transition ease-in-out">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">{{ $borrowed->code }}</td>
                    <td class="px-6 py-4">
                        <a href="{{route('member.book.show', $borrowed->book->id)}}" class="hover:text-primary-300 hover:underline" >
                            {{ \Illuminate\Support\Str::limit($borrowed->book->title, 25)  ?? '-' }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs {{
                            $borrowed->status === 'returned' ? 'bg-green-100 text-green-700' :
                            ($borrowed->status === 'overdue' ? 'bg-red-100 text-red-700' :
                             'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($borrowed->status) }}
                        </span>
                    </td>
                    <td>
                        <button type="button" class="flex items-center gap-3 text-font/60 font-normal">
                            <span>
                                <x-heroicon-s-eye class="size-4"/>
                            </span>
                            Detail
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center px-6 py-4">No borrowed books found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        </div>

    </div>
</section>
@endsection
