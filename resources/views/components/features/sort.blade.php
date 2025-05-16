<div class="relative inline-block text-left">
    <form method="get" id="sortForm">
        <select
            name="sort"
            id="sort"
            onchange="document.getElementById('sortForm').submit();"
            class="appearance-none capitalize first:text-lg pr-10  focus:outline-none focus:ring-0 border-none  cursor-pointer font-light "
        >
            <option value="" disabled selected>{{request('sort') ?? "Sort"}}</option>
            @foreach($sortItems as $sort)
                <option value="{{$sort}}">{{$sort}}</option>
            @endforeach
        </select>
    </form>
</div>
