<section>
    <!-- <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-black-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header> -->

    <!-- <form id="send-verification" method="post" action="{ route('verification.send') }">
        @csrf
    </form> -->

    <form method="post" action="{{ route('send') }}" class="mt-6 space-y-6">
        @csrf
        <!-- @method('patch') -->
        @method('post')


        <!-- Key type -->
        <div class="mt-2 mb-2">
            <x-input-label for="key" :value="__('Key type')" />
            <select id="type_user" name="key" class="form-control rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                @foreach($keys as $key)
                <option value="{{ $key->key }}" @if(old('key') == 0) selected @endif>{{ $key->name }}</option>
                @endforeach
            </select>

            @if(false && !$errors->get('key'))
                <p>{{ _('required field')}}</p>
            @endif

            <x-input-error :messages="$errors->get('key')" class="mt-2" />
        </div>

        <div class="mt-2 mb-2">
            <x-input-label for="first_name" :value="__('First name')" />
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name')" required autofocus autocomplete="first_name" />

            @if(false && !$errors->get('first_name'))
                <p>{{ _('required field')}}</p>
            @endif

            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>
        <div class="mt-2 mb-2">
            <x-input-label for="last_name" :value="__('Last name')" />
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name')" autofocus autocomplete="last_name" />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>
        <div class="mt-2 mb-2">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>
        <div class="mt-2 mb-2">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" required autofocus autocomplete="phone" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>
        <div class="mt-2 mb-2" id="date-container">
            <x-input-label for="ship_date" :value="__('Ship date')" />
            <x-text-input id="ship_date" class="date-picker" name="ship_date" type="text" class="mt-1 block w-full" :value="old('ship_date')" required autofocus autocomplete="ship_date" />
            <x-input-error class="mt-2" :messages="$errors->get('ship_date')" />
            <!-- <input type="text"> -->
        </div>

        <div class="mt-2 mb-2">
            <x-input-label for="transport_type" :value="__('Transport type')" />
            <select id="transport_type" name="transport_type" class="form-control rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                <option value="1" @if(old('transport_type') == 1) selected @endif>{{ _('Open') }}</option>
                <option value="2" @if(old('transport_type') == 2) selected @endif>{{ _('Enclosed') }}</option>
                <option value="3" @if(old('transport_type') == 3) selected @endif>{{ _('Driveaway') }}</option>
            </select>

            <!-- <x-text-input id="transport_type" name="transport_type" type="text" class="mt-1 block w-full" :value="old('transport_type')" required autofocus autocomplete="transport_type" /> -->
            <x-input-error class="mt-2" :messages="$errors->get('transport_type')" />
        </div>
        <div class="mt-2 mb-2">
            <x-input-label for="comment_from_shipper" :value="__('Comment from shipper')" />
            <x-text-input id="comment_from_shipper" name="comment_from_shipper" type="text" class="mt-1 block w-full" :value="old('comment_from_shipper')" autofocus autocomplete="comment_from_shipper" />
            <x-input-error class="mt-2" :messages="$errors->get('comment_from_shipper')" />
        </div>
        <div class="mt-2 mb-2">
            <x-input-label for="origin_city" :value="__('Origin city')" />
            <x-text-input id="origin_city" name="origin_city" type="text" class="mt-1 block w-full" :value="old('origin_city')" autofocus autocomplete="origin_city" />
            <x-input-error class="mt-2" :messages="$errors->get('origin_city')" />
        </div>
        <div class="mt-2 mb-2">
            <x-input-label for="origin_country" :value="__('Origin country')" />
            <x-text-input id="origin_country" name="origin_country" type="text" class="mt-1 block w-full" :value="old('origin_country')" autofocus autocomplete="origin_country" />
            <x-input-error class="mt-2" :messages="$errors->get('origin_country')" />
        </div>
        <div class="mt-2 mb-2">
            <x-input-label for="origin_postal_code" :value="__('Origin postal code')" />
            <x-text-input id="origin_postal_code" name="origin_postal_code" type="number" class="mt-1 block w-full" :value="old('origin_postal_code')" required autofocus autocomplete="origin_postal_code" />
            <x-input-error class="mt-2" :messages="$errors->get('origin_postal_code')" />
        </div>
        <div class="mt-2 mb-2">
            <x-input-label for="origin_state" :value="__('Origin state')" />
            <x-text-input id="origin_state" name="origin_state" type="text" class="mt-1 block w-full" :value="old('origin_state')" autofocus autocomplete="origin_state" />
            <x-input-error class="mt-2" :messages="$errors->get('origin_state')" />
        </div>
        <div class="mt-2 mb-2">
            <x-input-label for="destination_city" :value="__('Destination city')" />
            <x-text-input id="destination_city" name="destination_city" type="text" class="mt-1 block w-full" :value="old('destination_city')" autofocus autocomplete="destination_city" />
            <x-input-error class="mt-2" :messages="$errors->get('destination_city')" />
        </div>
        <div class="mt-2 mb-2">
            <x-input-label for="destination_country" :value="__('Destination country')" />
            <x-text-input id="destination_country" name="destination_country" type="text" class="mt-1 block w-full" :value="old('destination_country')" autofocus autocomplete="destination_country" />
            <x-input-error class="mt-2" :messages="$errors->get('destination_country')" />
        </div>
        <div class="mt-2 mb-2">
            <x-input-label for="destination_postal_code" :value="__('Destination postal code')" />
            <x-text-input id="destination_postal_code" name="destination_postal_code" type="number" class="mt-1 block w-full" :value="old('destination_postal_code')" required autofocus autocomplete="destination_postal_code" />
            <x-input-error class="mt-2" :messages="$errors->get('destination_postal_code')" />
        </div>
        <div class="mt-2 mb-2">
            <x-input-label for="destination_state" :value="__('Destination state')" />
            <x-text-input id="destination_state" name="destination_state" type="text" class="mt-1 block w-full" :value="old('destination_state')" autofocus autocomplete="destination_state" />
            <x-input-error class="mt-2" :messages="$errors->get('destination_state')" />
        </div>

        <div class="mt-2 mb-2">
            <x-input-label for="vehicle_inop" :value="__('Vehicle inop')" />
            <select id="vehicle_inop" name="vehicle_inop" class="form-control rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                <option value="1" @if(old('vehicle_inop') == 1) selected @endif>{{ _('Yes') }}</option>
                <option value="2" @if(old('vehicle_inop') == 2) selected @endif>{{ _('No') }}</option>
            </select>

            <!-- <x-text-input id="vehicle_inop" name="vehicle_inop" type="text" class="mt-1 block w-full" :value="old('vehicle_inop')" required autofocus autocomplete="vehicle_inop" /> -->
            <x-input-error class="mt-2" :messages="$errors->get('vehicle_inop')" />
        </div>

        <div class="mt-2 mb-2">
            <x-input-label for="vehicle_make" :value="__('Vehicle make')" />
            <x-text-input id="vehicle_make" name="vehicle_make" type="text" class="mt-1 block w-full" :value="old('vehicle_make')" required autofocus autocomplete="vehicle_make" />
            <x-input-error class="mt-2" :messages="$errors->get('vehicle_make')" />
        </div>

        <div class="mt-2 mb-2">
            <x-input-label for="vehicle_model" :value="__('Vehicle model')" />
            <x-text-input id="vehicle_model" name="vehicle_model" type="text" class="mt-1 block w-full" :value="old('vehicle_model')" required autofocus autocomplete="vehicle_model" />
            <x-input-error class="mt-2" :messages="$errors->get('vehicle_model')" />
        </div>

        <div class="mt-2 mb-2">
            <x-input-label for="vehicle_model_year" :value="__('Vehicle model year')" />
            <x-text-input id="vehicle_model_year" name="vehicle_model_year" type="number" class="mt-1 block w-full" :value="old('vehicle_model_year')" required autofocus autocomplete="vehicle_model_year" />
            <x-input-error class="mt-2" :messages="$errors->get('vehicle_model_year')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
