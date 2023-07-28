<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}



        <div class="mt-4">
            <x-filament::button class="" type="submit">
                创建
            </x-filament::button>
        </div>

    </form>
</x-filament::page>
