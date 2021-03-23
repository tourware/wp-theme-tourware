<template>
    <div :class="['advanced-tyto-list', config.classes]">
        <div class="tours-content">
            <component v-for="post in displayedPosts" v-bind:key="post.key" :is="config.layout_name" :post="post" :config="config"></component>
        </div>
        <nav aria-label="Page navigation example" :class="['tyto-pagination']">
            <ul v-if="config.pagination === 'numbers'" class="page-numbers numbers">
                <li class="page-item">
                    <a class="page-numbers" v-if="page !== 1" @click="page--"> Previous </a>
                </li>
                <li class="page-item">
                    <a class="page-numbers" v-for="pageNumber in pages" @click="page = pageNumber" :class="{current: page === pageNumber}"> {{pageNumber}} </a>
                </li>
                <li class="page-item">
                    <a @click="page++" v-if="page < pages.length" class="page-numbers"> Next </a>
                </li>
            </ul>
            <div v-if="config.pagination === 'load_more'" class="page-numbers load-more">
                <a @click="page++" v-if="page < pages.length" class="elementor-button page-numbers">{{config.load_more_text}}</a>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
  props: {
    posts: {
      type: Array
    },
    config: {
      type: Object
    }
  },
    data () {
        return {
            page: 1,
            perPage: this.config.per_page,
            pages: [],
        }
    },
    methods:{
        getPosts () {

        },
        setPages () {
            let numberOfPages = Math.ceil(this.posts.length / this.perPage);
            let end_size = 1;
            let mid_size = 2;
            let dots = false;
            if (numberOfPages > 1) {
                for (let index = 1; index <= numberOfPages; index++) {
                    this.pages.push(index);
                    // if (this.page === index) {
                    //     this.pages.push(index);
                    //     dots = true;
                    // } else {
                    //     if (index <= end_size || (index >= this.page - mid_size && index <= this.page + mid_size) || index > numberOfPages - end_size) {
                    //         this.pages.push(index);
                    //         dots = true;
                    //     } else if (dots) {
                    //         this.pages.push('...');
                    //         dots = false;
                    //     }
                    // }
                }
            }

        },
        paginate (posts) {
            console.log(this.config.pagination);
            let page = this.page;
            let perPage = this.perPage;
            let from; let to;
            if (this.config.pagination === 'numbers') {
                from = (page * perPage) - perPage;
                to = (page * perPage);
            } else if (this.config.pagination === 'load_more') {
                from = 0;
                to = (page * perPage);
            }
            return  posts.slice(from, to);
        }
    },
    computed: {
        displayedPosts () {
            return this.paginate(this.posts);
        }
    },
    watch: {

    },
    mounted() {
        this.setPages();
    },
    filters: {

    }
}
</script>