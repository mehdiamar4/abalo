<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>New Article</title>
</head>
<body>

<h1>Create New Article</h1>

<div id="new-article-app">
    <form v-on:submit.prevent="saveArticle">
        <label>Name</label><br>
        <input type="text" v-model="name">
        <br><br>

        <label>Price</label><br>
        <input type="number" step="0.01" v-model="price">
        <br><br>

        <label>Description</label><br>
        <input type="text" v-model="description">
        <br><br>

        <button type="submit">Save</button>
    </form>

    <p>@{{ message }}</p>
</div>

@vite(['resources/js/app.js'])

</body>
</html>
