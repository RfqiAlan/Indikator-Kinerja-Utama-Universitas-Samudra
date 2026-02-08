@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showSuccess({!! json_encode(session('success')) !!});
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showError({!! json_encode(session('error')) !!});
    });
</script>
@endif

@if(session('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showWarning({!! json_encode(session('warning')) !!});
    });
</script>
@endif

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showError({!! json_encode(implode("\n", $errors->all())) !!});
    });
</script>
@endif
