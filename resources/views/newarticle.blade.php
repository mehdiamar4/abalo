<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Artikel einstellen — Abalo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="new-article-page">
    <header class="site-header">
        <div class="shell header-inner">
            <a href="/" class="brand" aria-label="Abalo Startseite">
                <span class="brand-mark">a</span>
                <span>abalo</span>
            </a>
            <a href="/" class="back-link">← Zurück zu den Artikeln</a>
        </div>
    </header>

    <main class="create-layout shell">
        <section class="create-intro">
            <p class="label">Neues Angebot</p>
            <h1>Artikel einstellen</h1>
            <p>Trage die wichtigsten Informationen ein. Du kannst dein Angebot danach direkt auf der Startseite finden.</p>

            <div class="form-tips">
                <h2>Kurze Tipps</h2>
                <ul>
                    <li>Verwende einen eindeutigen Namen.</li>
                    <li>Beschreibe Zustand und wichtige Details.</li>
                    <li>Gib den Preis in Euro an.</li>
                </ul>
            </div>
        </section>

        <section class="create-card" id="new-article-app">
            <form v-on:submit.prevent="saveArticle" novalidate>
                <div class="form-field">
                    <label for="article-name">Name</label>
                    <input id="article-name" type="text" v-model.trim="name" maxlength="80" required placeholder="z. B. Sony Plattenspieler">
                    <small>Maximal 80 Zeichen</small>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label for="article-price">Preis in Euro</label>
                        <div class="price-input">
                            <input id="article-price" type="number" min="0.01" step="0.01" v-model="price" required placeholder="0,00">
                            <span>€</span>
                        </div>
                    </div>

                    <div class="form-field">
                        <label for="article-category">Kategorie</label>
                        <select id="article-category" v-model="categoryId" required>
                            <option value="" disabled>Bitte auswählen</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->ab_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-field">
                    <label for="article-description">Beschreibung</label>
                    <textarea id="article-description" v-model.trim="description" maxlength="1000" rows="6" required placeholder="Was sollte man über den Artikel wissen?"></textarea>
                    <small>Beschreibe den Artikel möglichst genau.</small>
                </div>

                <div class="form-actions">
                    <a href="/">Abbrechen</a>
                    <button type="submit" :disabled="saving">@{{ saving ? 'Wird gespeichert …' : 'Artikel veröffentlichen' }}</button>
                </div>

                <p v-if="message" class="form-message" :class="{ success: success, error: !success }" role="status">
                    @{{ message }}
                    <a v-if="success" href="/#articles">Artikel ansehen →</a>
                </p>
            </form>
        </section>
    </main>
</body>
</html>
