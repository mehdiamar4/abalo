import { createApp } from 'vue';
import ArticleSearch from './components/ArticleSearch.vue';

const mountEl = document.getElementById('article-search');
if (mountEl) {
    createApp(ArticleSearch).mount(mountEl);
}
