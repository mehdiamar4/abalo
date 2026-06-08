<template>
    <div>
        <h2>Dynamische Artikelsuche</h2>
        <input
            type="text"
            v-model="searchQuery"
            placeholder="Mindestens 3 Zeichen eingeben..."
            style="padding: 6px; width: 300px; font-size: 14px;"
        />

        <p v-if="searchQuery.length > 0 && searchQuery.length < 3" style="color: gray;">
            Bitte mindestens 3 Zeichen eingeben...
        </p>

        <p v-if="loading">Suche läuft...</p>

        <p v-if="error" style="color: red;">{{ error }}</p>

        <table v-if="articles.length > 0" border="1" cellpadding="8" style="margin-top: 10px;">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Preis</th>
                <th>Beschreibung</th>
            </tr>
            <tr v-for="article in articles" :key="article.id">
                <td>{{ article.id }}</td>
                <td>{{ article.name }}</td>
                <td>{{ article.price }} €</td>
                <td>{{ article.description }}</td>
            </tr>
        </table>

        <p v-if="searchQuery.length >= 3 && !loading && articles.length === 0 && !error">
            Keine Artikel gefunden.
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
        };
    },
    watch: {
        searchQuery(newVal) {
            if (newVal.length >= 3) {
                this.search(newVal);
            } else {
                this.articles = [];
                this.error = null;
            }
        }
    },
    methods: {
        async search(query) {
            this.loading = true;
            this.error = null;
            try {
                const response = await fetch(`/api/articles?search=${encodeURIComponent(query)}`);
                if (!response.ok) throw new Error('Fehler beim Laden der Artikel');
                const data = await response.json();
                this.articles = data.articles.slice(0, 5);
            } catch (err) {
                this.error = err.message;
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
