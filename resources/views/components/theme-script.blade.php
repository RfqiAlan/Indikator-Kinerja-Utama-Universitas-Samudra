<script>
    // Prevent Flash of Unstyled Content (FOUC) for Dark Mode
    (function() {
        const savedTheme = localStorage.getItem('darkMode');
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (savedTheme === 'true' || (savedTheme === null && systemDark)) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('darkMode', 'true');
        } else {
            document.documentElement.classList.remove('dark');
            if (savedTheme === null) {
                localStorage.setItem('darkMode', 'false');
            }
        }
    })();
</script>
