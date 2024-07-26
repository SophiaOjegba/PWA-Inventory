<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Equipment Manager</title>
    <link rel="stylesheet" href="/main.css">
    <link rel="manifest" href="/manifest.json">
    <script>
       if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js', { scope: '/' })
            .then(registration => {
                console.log('Service Worker registered with scope:', registration.scope);
            })
            .catch(error => {
                console.error('Service Worker registration failed:', error);
            });
    });
}


    </script>
</head>
<body>
    <div id="app">
        <img src="/icon-152x152.png" alt="icon">
        <form id="searchForm">
            <input type="text" id="equipmentNumber" placeholder="Equipment Number">
            <button type="submit">Search</button>
        </form>
        <div>
            <input type="text" id="name" placeholder="Name">
            <textarea id="description" placeholder="Description"></textarea>
            <button id="updateButton">Update</button>
        </div>
        <div>
            <input type="file" id="fileInput">
            <button id="uploadButton">Upload</button>
        </div>
        <button id="syncButton">Sync Data</button>
    </div>
    <script src="https://unpkg.com/idb@5.0.8/build/iife/index-min.js">
    </script>
    <script src="/js/indexeddb.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>
