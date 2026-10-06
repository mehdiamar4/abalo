<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Artikel auf Abalo entdecken und verkaufen.">
    <title>Abalo — Kaufen und verkaufen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/search.js'])
</head>
<body class="marketplace-page">
    <a class="skip-link" href="#articles">Zu den Artikeln</a>

    <header class="site-header" id="top">
        <div class="shell header-inner">
            <a href="/" class="brand" aria-label="Abalo Startseite">
                <span class="brand-mark">a</span>
                <span>abalo</span>
            </a>

            <nav class="desktop-nav" aria-label="Hauptnavigation">
                <a href="#articles">Artikel</a>
                <a href="#categories">Kategorien</a>
                <a href="/newarticle">Verkaufen</a>
            </nav>

            <div class="header-actions">
                <button class="cart-trigger" type="button" aria-label="Warenkorb öffnen" aria-controls="cart-drawer">
                    <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M3 4h2l2 10h10l2-7H7M9 20h.01M17 20h.01"/></svg>
                    <span id="cart-count">0</span>
                </button>
                <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="mobile-nav" aria-label="Menü öffnen">☰</button>
            </div>
        </div>
        <nav class="mobile-nav" id="mobile-nav" aria-label="Mobile Navigation" hidden>
            <a href="#articles">Artikel</a>
            <a href="#categories">Kategorien</a>
            <a href="/newarticle">Verkaufen</a>
        </nav>
    </header>

    <main>
        <section class="hero shell">
            <div class="hero-copy">
                <p class="label">Kleinanzeigen einfach gemacht</p>
                <h1>Finden, kaufen,<br><span>weitergeben.</span></h1>
                <p class="hero-text">Auf Abalo findest du gebrauchte Artikel und kannst eigene Angebote einstellen.</p>
                <div id="article-search"></div>
                <p class="article-count">Aktuell {{ $articles->count() }} Artikel verfügbar</p>
            </div>

            @php
                $featured = $articles->firstWhere('id', 1) ?? $articles->first();
            @endphp
            @if ($featured)
                <div class="featured-card">
                    <img src="/images/{{ $featured->id }}.jpg" alt="{{ $featured->ab_name }}" onerror="this.src='/images/{{ $featured->id }}.png'">
                    <div>
                        <p>Aus den Angeboten</p>
                        <h2>{{ $featured->ab_name }}</h2>
                        <strong>{{ number_format($featured->ab_price, 2, ',', '.') }} €</strong>
                    </div>
                </div>
            @endif
        </section>

        <section class="categories shell" id="categories" aria-labelledby="categories-title">
            <div class="section-title">
                <div>
                    <p class="label">Kategorien</p>
                    <h2 id="categories-title">Direkt loslegen</h2>
                </div>
            </div>
            <div class="category-list">
                <a href="/?category=2#articles"><span>01</span> Autos <b>→</b></a>
                <a href="/?category=7#articles"><span>02</span> Audio <b>→</b></a>
                <a href="/?category=10#articles"><span>03</span> Smartphones <b>→</b></a>
                <a href="/?category=3#articles"><span>04</span> Ersatzteile <b>→</b></a>
            </div>
        </section>

        <section class="catalog" id="articles" aria-labelledby="articles-title">
            <div class="shell">
                <div class="catalog-header">
                    <div>
                        <p class="label">Angebote</p>
                        <h2 id="articles-title">Alle Artikel</h2>
                    </div>
                    <form class="filter-search" method="GET" action="/" role="search">
                        <label class="sr-only" for="catalog-search">Artikel filtern</label>
                        <input id="catalog-search" type="search" name="search" value="{{ $search }}" placeholder="Artikel filtern">
                        <button type="submit">Suchen</button>
                    </form>
                </div>

                @if ($search)
                    <div class="search-summary">
                        <span>{{ $articles->count() }} Treffer für „{{ $search }}“</span>
                        <a href="/#articles">Filter löschen</a>
                    </div>
                @endif

                @if ($categoryName)
                    <div class="search-summary">
                        <span>{{ $articles->count() }} Artikel in „{{ $categoryName }}“</span>
                        <a href="/#articles">Filter löschen</a>
                    </div>
                @endif

                @if ($articles->isEmpty())
                    <div class="empty-state">
                        <h3>Keine Artikel gefunden</h3>
                        <p>Versuche es mit einem anderen Suchbegriff.</p>
                        <a href="/#articles">Alle Artikel anzeigen</a>
                    </div>
                @else
                    <div class="product-grid">
                        @foreach ($articles as $article)
                            <article class="product-card">
                                <div class="product-image">
                                    @php
                                        $jpg = public_path('images/' . $article->id . '.jpg');
                                        $png = public_path('images/' . $article->id . '.png');
                                    @endphp
                                    @if (file_exists($jpg))
                                        <img src="/images/{{ $article->id }}.jpg" alt="{{ $article->ab_name }}" loading="lazy">
                                    @elseif (file_exists($png))
                                        <img src="/images/{{ $article->id }}.png" alt="{{ $article->ab_name }}" loading="lazy">
                                    @else
                                        <div class="image-placeholder">Kein Bild</div>
                                    @endif
                                </div>
                                <div class="product-info">
                                    <h3>{{ $article->ab_name }}</h3>
                                    <p>{{ $article->ab_description }}</p>
                                    <div class="product-bottom">
                                        <strong>{{ number_format($article->ab_price, 2, ',', '.') }} €</strong>
                                        <button class="add-button" type="button" onclick="addToCart({{ $article->id }}, @js($article->ab_name))">In den Warenkorb</button>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section class="sell-section shell">
            <div>
                <p class="label">Selbst verkaufen</p>
                <h2>Du hast etwas übrig?</h2>
                <p>Erstelle ein Angebot und gib dem Artikel ein neues Zuhause.</p>
            </div>
            <a href="/newarticle">Artikel einstellen →</a>
        </section>
    </main>

    <footer class="site-footer">
        <div class="shell">
            <a href="#top" class="brand"><span class="brand-mark">a</span><span>abalo</span></a>
            <p>Ein studentisches Marktplatzprojekt.</p>
            <small>© {{ date('Y') }} Abalo</small>
        </div>
    </footer>

    <div class="drawer-backdrop" data-cart-close hidden></div>
    <aside class="cart-drawer" id="cart-drawer" aria-label="Warenkorb" aria-hidden="true">
        <div class="drawer-header">
            <h2>Warenkorb</h2>
            <button type="button" data-cart-close aria-label="Warenkorb schließen">×</button>
        </div>
        <ul id="cart" class="cart-list"></ul>
        <div class="cart-empty" id="cart-empty">
            <p>Der Warenkorb ist leer.</p>
        </div>
    </aside>

    <div class="toast" id="cart-toast" role="status" aria-live="polite"></div>
</body>
</html>
