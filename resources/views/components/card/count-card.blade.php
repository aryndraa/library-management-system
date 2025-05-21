<div
    class="p-6 bg-bgWidget rounded-xl"
    x-data="{
        count: 0,
        target: 100,
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
        <h2 class="text-3xl font-normal mb-1.5">
            <span x-text="count"></span>+
        </h2>
        <h3 class="text-font/60">Variant Book</h3>
    </div>
    <p class="text-font/60">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    </p>
</div>
