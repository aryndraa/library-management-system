<div class="bg-bgWidget p-6 w-[28%] rounded-xl">
    <div>
        <h3 class="text-xl mb-3">Categories</h3>
        <form method="get">
            @foreach($categories as $category)
                <div class="py-2 flex gap-3 items-center">
                    <input
                        type="checkbox"
                        name="categories[]"
                        value="{{$category['name']}}"
                        id="category_{{ $loop->index }}"
                        onchange="this.form.submit()"
                        class="peer size-5 cursor-pointer transition-all appearance-none rounded  border border-slate-300 checked:bg-primary-300 checked:border-primary-200  checked:hover:bg-primary-300 focus:bg-primary-100 checked:focus:bg-primary-100 "
                        {{ in_array($category['name'], request()->get('categories', [])) ? 'checked' : '' }}
                    >
                    <label for="category_{{ $loop->index }}">{{$category['name']}}</label>
                </div>
            @endforeach
        </form>
    </div>
</div>
