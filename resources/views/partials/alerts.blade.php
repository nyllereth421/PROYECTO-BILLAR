@if (session('success'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            title: '¡Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif

@if (session('confirm'))
    <script>
        function confirmDelete(form) {
            Swal.fire({
                title: '{{ session('confirm')['title'] }}',
                text: '{{ session('confirm')['text'] }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ session('confirm')['confirmButtonText'] }}',
                cancelButtonText: '{{ session('confirm')['cancelButtonText'] }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
@endif