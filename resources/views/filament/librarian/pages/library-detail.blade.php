<x-filament::page>
    <section class="library-detail">
        <div class="images">
            @foreach($this->library->getMedia('library') as $media)
                <div class="img">
                    <img src="{{$media->getUrl()}}" alt="" class="">
                    <div class="overlay"></div>
                </div>
            @endforeach
        </div>
    </section>
</x-filament::page>

{{--<p>{{$this->form}}</p>--}}
