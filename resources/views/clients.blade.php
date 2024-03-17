<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Clients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="font-semibold">
                        List of all Clients
                    </p>

                    @foreach ($clients as $client)
                        <div class="py-4">
                            <h3 class="text-xl font-bold">{{ $client->name }}</h3>
                            <p>{{ $client->redirect }}</p>
                            <div class='py-2 text-gray-200'>
                                <p>ID : {{ $client->id }}</p>
                                <p>SECRET: {{ $client->secret }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="/oauth/clients" method="POST">
                        @csrf
                        <div>
                            <x-input-label for="name">Name</x-input-label>
                            <x-text-input id="name" name="name" type="text" class="block w-full mt-1"
                                required autofocus autocomplete="name" />
                        </div>
                        <div>
                            <x-input-label for="redirect">Redirect URI</x-input-label>
                            <x-text-input id="redirect" name="redirect" type="text" class="block w-full mt-1"
                                required autofocus autocomplete="redirect" />
                        </div>
                        <div>
                            <x-primary-button class="mt-4">Create Client</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
