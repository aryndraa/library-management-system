@extends('layouts.show', ['routeDirect' => 'member.home'])

@section('content')
    <section
        class="grid grid-cols-4 gap-16"
    >
        <x-navigation.sidebar/>

        <div class="col-span-3 ">
            <div>
                <h2 class="text-2xl mb-8">Book Likes</h2>
                <table class="min-w-full bg-white border  border-font/20 rounded-lg">
                    <thead class="text-left text-sm text-gray-700 uppercase ">
                    <tr>
                        <th class="px-6 py-3 bg-primary-300 text-white  font-normal ">#</th>
                        <th class="px-6 py-3 min-w-64    bg-primary-300 text-white  font-normal ">Title</th>
                        <th class="px-6 py-3 min-w-52 bg-primary-300 text-white  font-normal">ISBN</th>
                        <th class="px-6 py-3 min-w-52 bg-primary-300 text-white  font-normal">Category</th>
                        <th class="px-6 py-3 min-w-52 bg-primary-300 text-white  font-normal">Library</th>
                    </tr>
                    </thead>
                    <tbody class="text-font">
                    @forelse ($books as $index => $book)
                        <tr class="border-t border-font/20 transition ease-in-out {{
                                $book->status === 'returned' ? 'bg-neutral-100 text-font/60' : ''
                            }}">
                            <td class="px-6 py-4 text-sm">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm  relative">
                                <a href="{{route('member.book.show', $book->id)}}" class="hover:text-primary-300 hover:underline group" >
                                    {{ \Illuminate\Support\Str::limit($book->title, 30)  ?? '-' }}
                                    <div class="absolute hidden group-hover:block -right-52 bottom-12 z-10">
                                        <div class="bg-bgWidget shadow rounded-xl p-4 grid grid-cols-3 gap-6 w-80">
                                            <img src="{{ $book->getFirstMediaUrl('book') }}" alt="" class="h-28  col-span-1 rounded-xl">
                                            <div class="col-span-2">
                                                <h3 class="mb-2">{{ $book->title }}</h3>
                                                <p class="text-sm text-font/60">{{ \Illuminate\Support\Str::limit($book->synopsis, 60) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </td>

                            <td class="px-6 py-4 text-sm">
                                {{  $book->isbn }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                {{ $book->category->name }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ $book->library->name }}
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center px-6 py-4">No books found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="mt-4 flex justify-end">
                    {{ $books->onEachSide(1)->links('vendor.pagination.custom-tailwind') }}
                </div>
            </div>

        </div>
    </section>
@endsection
