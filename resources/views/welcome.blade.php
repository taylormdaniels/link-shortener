<!DOCTYPE html>
<html lang="en">
<head>
    @livewireStyles 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Link Shortener</title>
</head>
<body class="antialiased">
    <h1>Link Shortener</h1>
    {{ $slot }}
    @livewireScripts
    <form id="shorten-form">
        <label for="url">URL:</label>
        <input type="url" name="url" placeholder="https://example.com" required>
        <label for="slug">Specialize Your Link:</label>
        <input type="text" name="slug">
        <button type="submit">Shorten</button>
    </form>
    <p id="result"></p>
    <script>
        document.getElementById('shorten-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const res = await fetch('/api/links', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ url: form.url.value, slug: form.slug.value })
            });
            const out = document.getElementById('result');
            if (res.ok) {
                const data = await res.json();
                out.innerHTML = `<a href="${data.short}">${data.short}</a>`;
                form.reset();
            } else {
                out.textContent = 'Error creating link';
            }
        });
    </script>
</body>
</html>
