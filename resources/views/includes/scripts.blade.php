<script>
    const required = document.querySelectorAll('.required');
    required.forEach(element => {
        element.insertAdjacentHTML('beforeend', '<span class="text-red-500">*</span>');
    }); 
</script>
