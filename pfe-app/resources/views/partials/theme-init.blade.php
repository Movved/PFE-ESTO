<script>
(function() {
    var dark = localStorage.getItem('theme') === 'dark';
    var bg = dark ? '#1C1C1E' : '#F5F5F7';
    if (dark) document.documentElement.classList.add('dark');
    document.documentElement.style.cssText = 'background:' + bg + ';color-scheme:' + (dark ? 'dark' : 'light');
})();
</script>
<style>
    html       { background: #F5F5F7; color-scheme: light; }
    html.dark  { background: #1C1C1E; color-scheme: dark;  }
    body       { background: inherit; }
</style>
