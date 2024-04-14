<x-filament-widgets::widget>
    {{-- Heading: Campaigns --}}
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <h2 class="text-lg font-semibold leading-6 text-gray-950 dark:text-white flex-1">
                {{ __('Campaigns') }}
            </h2>
            <x-filament::button href="{{ route('filament.admin.resources.campaigns.create') }}" color="gray"
                icon="heroicon-o-plus-circle" icon-alias="heroicon-o-plus-circle" labeled-from="sm" tag="a">
                {{ __('Create New Campaign') }}
            </x-filament::button>
        </div>

        <div class="flex items-center flex-wrap gap-x-3 mt-3">
            @foreach ($this->campaignsByStatus as $status => $campaigns)
                <x-filament::link
                {{-- campaigns?tableFilters[status][values][0]=completed --}}
                {{-- :href="route('filament.admin.resources.campaigns.index', ['tableFilters' => ['status' => ['values' => [$status]]]])" --}}
                :href="route('filament.admin.resources.campaigns.index', 'tableFilters[status][values][0]=' . $status)"
                >
                    <x-filament::badge href="{{ route('filament.admin.resources.campaigns.index') }}"
                        color="{{ $campaigns[0]->status->getColor() }}" class="mb-4">
                        {{ count($campaigns) }} - {{ $status }}
                    </x-filament::badge>
                </x-filament::link>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
