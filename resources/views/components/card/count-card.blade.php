@props([
    'total',
    'name'
])

<div
    class="p-4 lg:p-6 bg-bgWidget rounded-xl w-full last:col-span-2 lg:last:col-span-1"
    x-data="{
        count: 0,
        target: {{ $total }},
        animated: false,
        startCount() {
            if (this.animated) return;
            this.animated = true;
            const interval = setInterval(() => {
                if (this.count < this.target) {
                    this.count++;
                } else {
                    clearInterval(interval);
                }
            }, 20);
        }
    }"
    x-intersect.once="startCount()"
>
    <div class="mb-2">
        <h2 class="text-2xl lg:text-3xl font-normal lg:mb-1.5">
            <span x-text="count"></span>+
        </h2>
        <h3 class="text-sm lg:text-base text-font">Variant {{ $name }}</h3>
    </div>
    <p class="text-sm lg:text-base  text-font/60">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    </p>
</div>
