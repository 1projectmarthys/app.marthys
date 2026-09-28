<div>
    <input 
        type="text" 
        wire:model="value" 
        value="{{ $formattedValue }}"
        id="{{ $fieldId }}"
        disabled
        class="block w-full disabled:bg-gray-100 border-gray-300 rounded-lg shadow-sm"
    />
</div>