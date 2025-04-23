<x-filament-panels::page>
    <x-filament-panels::form wire:submit="update">


        <h2 class="text-3xl font-medium mb-3">Reset Password</h2>
        <div class="p-4 bg-white flex flex-col gap-6">
            {{ $this->form }}

            <x-filament-panels::form.actions
                :actions="$this->getFormActions()"
            />
        </div>


    </x-filament-panels::form>
</x-filament-panels::page>
