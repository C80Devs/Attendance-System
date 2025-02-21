<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session()->has('error'))
        toastr.error("{{ session('error') }}", "Error!");
        @endif

        @if (session()->has('notice'))
        toastr.warning("{{ session('notice') }}", "Notice!");
        @endif

        @if (session()->has('success'))
        toastr.success("{{ session('success') }}", "Success!");
        @endif

        @if (session()->has('info'))
        toastr.info("{{ session('info') }}", "Info!");
        @endif

        @if (session()->has('primary'))
        toastr.info("{{ session('primary') }}", "Primary!");
        @endif

        @if (session()->has('secondary'))
        toastr.info("{{ session('secondary') }}", "Secondary!");
        @endif

        @if (session()->has('light'))
        toastr.info("{{ session('light') }}", "Light!");
        @endif

        @if (session()->has('dark'))
        toastr.info("{{ session('dark') }}", "Dark!");
        @endif

        Livewire.on('alert', (event) => {
            event = event[0];
            let message = event.message;
            let type = event.type;

            if (type === 'error') {
                toastr.error(message);
            } else if (type === 'success') {
                toastr.success(message);
            } else if (type === 'warning') {
                toastr.warning(message);
            } else if (type === 'info') {
                toastr.info(message);
            }
        });
    });
</script>
