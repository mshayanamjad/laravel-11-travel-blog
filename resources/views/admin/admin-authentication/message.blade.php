<div id="toast-container"></div>
@if(Session::has('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            showToast("{!! Session::get('success') !!}", 'success', 5000); // Pass the correct type
        });
    </script>
@endif

@if(Session::has('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            showToast("{{ Session::get('error') }}", 'error', 5000); // Pass the correct type
        });
    </script>
@endif

