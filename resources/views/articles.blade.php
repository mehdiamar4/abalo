<!DOCTYPE html>
<html>
<head>
    <title>Articles</title>
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div id="menu"></div>
<h1>Articles</h1>
<form method="GET" action="/articles">
    <input type="text" name="search" value="{{ $search }}">
    <button type="submit">Search</button>
</form>
<h2>Shopping Cart</h2>
<ul id="cart"></ul>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Description</th>
        <th>Image</th>
        <th>Add</th>
    </tr>

    @foreach ($articles as $article)
        <tr>
            <td>{{ $article->id }}</td>
            <td>{{ $article->ab_name }}</td>
            <td>{{ $article->ab_price }}</td>
            <td>{{ $article->ab_description }}</td>
            <td>
                @php
                    $jpg = public_path('images/' . $article->id . '.jpg');
                    $png = public_path('images/' . $article->id . '.png');
                @endphp

                @if (file_exists($jpg))
                    <img src="/images/{{ $article->id }}.jpg" width="100">
                @elseif (file_exists($png))
                    <img src="/images/{{ $article->id }}.png" width="100">
                @endif
            </td>
            <td>
                <button onclick="addToCart({{ $article->id }}, '{{ $article->ab_name }}')">+</button>
            </td>
        </tr>
    @endforeach

</table>
<script src="/js/cookiecheck.js"></script>
<script src="/js/cart.js"></script>
<script src="{{ asset('js/menu.js') }}"></script>
</body>
</html>
