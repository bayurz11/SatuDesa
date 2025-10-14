<div x-data x-init="flatpickr($refs.input, {
    dateFormat: 'd-m-Y',
    defaultDate: '{{ now()->toDateString() }}',
    onChange: function(selectedDates, dateStr) {
        @this.set('model', dateStr);
    }
})" class="relative rounded-md shadow-sm">

    <!-- Input -->
    <input x-ref="input" type="text" id="tanggal" placeholder="Pilih tanggal..."
        class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg 
               bg-gray-50 text-gray-700 
               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
               hover:border-blue-400 transition"
        value="{{ $model }}">

    <!-- Icon -->
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
    </div>
</div>
