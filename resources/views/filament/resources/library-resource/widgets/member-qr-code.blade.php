<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Member Attendance
        </x-slot>

        {!! $this->getQrCode() !!}
    </x-filament::section>
</x-filament-widgets::widget>
