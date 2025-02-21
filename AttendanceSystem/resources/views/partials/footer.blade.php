<!-- Include Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@php
    use App\Models\SettingsModel;$settings = SettingsModel::first();
@endphp
<script>
    toastr.options = {
        "closeButton": false,
        "progressBar": true,
        "preventDuplicates": true,
        "onclick": null,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "positionClass": "toast-top-full-width",
        "showDuration": "300",
        "hideDuration": "1000",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
</script>

<!-- Check if the current route is not 'profile' -->
@if (request()->route()->getName() !== 'profile')
    <div class="mt-2">
        <footer style="background-color: var(--primaryColor)" class="text-white py-2 fixed-bottom ">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <p>&copy; <span id="currentYear"></span> {{ $settings->name ?? config('app.name') }},
                           All
                           rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<script>
    // Dynamically update the footer year
    document.getElementById("currentYear").textContent = new Date().getFullYear();
</script>
