<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Notification ways
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Choose 2 methods to be notified
        </p>
    </header>

    <form id="update-notification" method="post" action="{{ route('user.updateNotificationMethods') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('user.updateNotificationMethods') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="notification_methods" :value="__('Select Notification Methods (Max: 2)')" />
            <div class="mt-1">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="notification_methods[]" value="email" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        {{ in_array('email', auth()->user()->notification_methods ?? []) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-600">Email</span>
                </label>
                <br>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="notification_methods[]" value="sms" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        {{ in_array('sms', auth()->user()->notification_methods ?? []) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-600">SMS</span>
                </label>
                <br>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="notification_methods[]" value="telegram" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        {{ in_array('telegram', auth()->user()->notification_methods ?? []) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-600">Telegram</span>
                </label>
                <br>
                <label>Telegram Chat ID:</label>
                <input type="text" name="telegram_chat_id" value="{{ old('telegram_chat_id', auth()->user()->telegram_chat_id) }}">
                <br>

            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>

    @if (session('error'))
        <p class="text-sm text-red-600 mt-2">{{ session('error') }}</p>
    @endif
</section>
