<div>

    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
        {{ $value ?? $slot }}
    </label>
    <input type="text"
           class="form-control mt-1"
           id="datepicker"
           name="{{ $attributes['name'] }}"
           value="{{ $value }}"
           autocomplete="off"/>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#datepicker", {
                dateFormat: "Y-m-d",
                minDate: "today" // Sets the minimum date to today
            });
        });
    </script>
</div>
