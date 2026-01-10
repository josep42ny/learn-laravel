<x-layout>
    <x-slot:heading>
        {{ $job['title'] }}
    </x-slot:heading>
    <p>This job pays ${{ $job['salary'] }} per year.</p>
</x-layout>