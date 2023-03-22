<div class="mt-2 mb-2">
    <x-input-label for="datetimepicker" :value="__('Сhoose a date and time to send the form (optional field)')" />
    <x-text-input id="datetimepicker" name="datetimepicker" type="text" class="mt-1 block w-full" :value="old('datetimepicker')" autocomplete="datetimepicker" />
    <x-input-error class="mt-2" :messages="$errors->get('datetimepicker')" />
</div>
