<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Link Shortener</title>
</head>
<body>
    <h1>Link Shortener</h1>
    <form id="shorten-form">
        <input type="url" name="url" placeholder="https://example.com" required>
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
                body: JSON.stringify({ url: form.url.value })
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
