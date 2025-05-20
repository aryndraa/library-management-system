@extends('layouts.show', ['routeDirect' => 'member.home'])

@section('content')
<section
    x-data="{ openModalId: null }"
    x-init="
        window.addEventListener('close-modal', event => {
            if (event.detail?.id) {
                openModalId = null;
            }
        })
    "
    class="grid grid-cols-4 gap-16">
    <x-navigation.sidebar/>

    @livewire('borrowed-books')

</section>
@endsection
