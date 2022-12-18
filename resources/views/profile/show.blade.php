
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased bg-light">
        <x-jet-banner />
        @livewire('navigation-menu')

        <!-- Page Content -->
        <main class="container my-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <x-slot name="header">
                            <h2 class="h4 font-weight-bold">
                                {{ __('Profile') }}
                            </h2>
                        </x-slot>

                        <div>
                            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                                @livewire('profile.update-profile-information-form')

                                <x-jet-section-border />
                            @endif

                            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                                @livewire('profile.update-password-form')

                                <x-jet-section-border />
                            @endif

                            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                                @livewire('profile.two-factor-authentication-form')

                                <x-jet-section-border />
                            @endif

                            @livewire('profile.logout-other-browser-sessions-form')

                            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                                <x-jet-section-border />

                                @livewire('profile.delete-user-form')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>

        @stack('modals')

        @livewireScripts

        @stack('scripts')
    </body>
</html>
