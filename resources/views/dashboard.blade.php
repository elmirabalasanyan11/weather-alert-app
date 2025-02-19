<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h4>
                        Welcome to your personalized weather dashboard!
                    </h4>

                    <p>Here, you can:</p>

                    <p>Receive Timely Alerts: Get notified about upcoming rain or high UV index levels in the next hour.</p>

                    <p>Stay Prepared: Plan your activities with confidence, knowing you'll be informed of any imminent weather changes.</p>

                    <p>Customize Notification Preferences: Choose which cities you want to receive alerts for.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
