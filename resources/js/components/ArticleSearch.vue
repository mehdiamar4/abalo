<template>
    <div class="smart-search">
        <div class="smart-search-bar">
            <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
            <label class="sr-only" for="smart-search-input">Artikel suchen</label>
            <input
                id="smart-search-input"
                type="search"
                v-model.trim="searchQuery"
                placeholder="Was möchtest du entdecken?"
                autocomplete="off"
                @keydown.escape="clearResults"
            >
            <button type="button" @click="browseResults">Entdecken</button>
        </div>

        <p v-if="searchQuery.length > 0 && searchQuery.length < 3" class="search-feedback">
            Noch {{ 3 - searchQuery.length }} Zeichen bis zur Suche …
        </p>
        <p v-else-if="loading" class="search-feedback">Wir suchen passende Fundstücke …</p>
        <p v-else-if="error" class="search-feedback error">{{ error }}</p>

        <ul v-if="articles.length > 0" class="live-results" aria-label="Suchergebnisse">
            <li v-for="article in articles" :key="article.id" class="live-result">
                <img class="result-thumb" :src="imageUrl(article.id)" :alt="article.name" @error="usePngFallback">
                <div class="result-copy">
                    <strong>{{ article.name }}</strong>
                    <span>{{ article.description }}</span>
                </div>
                <strong class="result-price">{{ formatPrice(article.price) }}</strong>
                <button class="result-add" type="button" @click="add(article)" :aria-label="`${article.name} in den Warenkorb`">+</button>
            </li>
        </ul>

        <p v-if="searchQuery.length >= 3 && !loading && articles.length === 0 && !error" class="search-feedback">
            Keine Treffer – probiere einen allgemeineren Begriff.
        </p>
    </div>
</template>

<script>
export default {
    name: 'ArticleSearch',
    data() {
        return {
            searchQuery: '',
            articles: [],
            loading: false,
            error: null,
            requestController: null,
        };
    },
    watch: {
        searchQuery(newValue) {
            if (newValue.length >= 3) {
                this.search(newValue);
            } else {
                this.clearResults();
            }
        },
    },
    methods: {
        async search(query) {
            if (this.requestController) this.requestController.abort();
            this.requestController = new AbortController();
            this.loading = true;
            this.error = null;

            try {
                const response = await fetch(`/api/articles?search=${encodeURIComponent(query)}`, {
                    signal: this.requestController.signal,
                    headers: { Accept: 'application/json' },
                });
                if (!response.ok) throw new Error('Die Suche ist gerade nicht erreichbar.');
                const data = await response.json();
                this.articles = data.articles.slice(0, 4);
            } catch (error) {
                if (error.name !== 'AbortError') this.error = error.message;
            } finally {
                this.loading = false;
            }
        },
        clearResults() {
            this.articles = [];
            this.error = null;
        },
        browseResults() {
            if (!this.searchQuery) {
                document.querySelector('#discover')?.scrollIntoView({ behavior: 'smooth' });
                return;
            }
            window.location.href = `/?search=${encodeURIComponent(this.searchQuery)}#discover`;
        },
        add(article) {
            if (window.addToCart) window.addToCart(article.id, article.name);
        },
        imageUrl(id) {
            return `/images/${id}.jpg`;
        },
        usePngFallback(event) {
            if (!event.target.src.endsWith('.png')) event.target.src = event.target.src.replace('.jpg', '.png');
        },
        formatPrice(price) {
            return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(Number(price));
        },
    },
};
</script>
