<footer class="bg-dark text-white py-4 fixed-bottom">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <p>&copy; <span id="currentYear"></span> C80 Limited. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
{{--
<script src="{{ asset('assets/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('assets/plugins/highlight/highlight.pack.js') }}"></script>
<script src="{{ asset('assets/plugins/fullcalendar/lib/main.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/main.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/pages/datatables.js') }}"></script>
<script src="{{ asset('assets/js/pages/calendar.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/settings.js') }}"></script>
<script src="{{asset('assets/plugins/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/js/pages/datepickers.js')}}"></script>
--}}


<link
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
    rel="stylesheet"/>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
    // Initialize Toastr options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }


        @if (session('success'))
        toastr.success("{{ session('success') }}");
       @endif

       @if (session('error'))
       toastr.success("{{ session('error') }}");
    @endif


</script>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

    });


</script>



@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>toastr.error('{{$error}}')</script>
    @endforeach

@endif


