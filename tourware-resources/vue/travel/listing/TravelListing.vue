<template>
    <div :class="['advanced-tyto-list', config.layout_class]">
        <select v-if="config.filter_destinations" v-model="selectedDestination">
            <option value="">{{config.filter_destinations_text}}</option>
            <option v-for="(destination, dest_index) in config.filter_destinations" :value="dest_index">{{destination}}</option>
        </select>
        <select v-if="config.filter_categories" v-model="selectedCategory">
            <option value="">{{config.filter_categories_text}}</option>
            <option v-for="(category, cat_index) in config.filter_categories" :value="cat_index">{{category}}</option>
        </select>
        <select v-if="config.sorting" v-model="selectedSorting">
            <option v-for="(sorting, sort_index) in config.sorting" :value="sort_index">{{sorting}}</option>
        </select>
        <div :class="[config.classes]">
            <div class="tours-content">
                <component v-for="post in displayedPosts" v-bind:key="post.key" :is="config.layout_name" :post="post"
                           :config="config"></component>
            </div>
        </div>
        <nav aria-label="Page navigation example" :class="['listing-pagination']">
            <ul v-if="config.pagination === 'numbers'" class="page-numbers numbers">
                <li class="page-item">
                    <a class="page-numbers" v-if="page !== 1" @click="page--"> Previous </a>
                </li>
                <li class="page-item">
                    <a class="page-numbers" v-for="pageNumber in pages" @click="page = pageNumber"
                       :class="{current: page === pageNumber}"> {{pageNumber}} </a>
                </li>
                <li class="page-item">
                    <a @click="page++" v-if="page < pages.length" class="page-numbers"> Next </a>
                </li>
            </ul>
            <div v-if="config.pagination === 'load_more'" class="page-numbers load-more">
                <a @click="page++" v-if="page < pages.length && pages.length > 1" class="elementor-button page-numbers">{{config.load_more_text}}</a>
            </div>
        </nav>
    </div>
</template>

<script>
    var j = jQuery.noConflict();
    export default {
        props: {
            posts: {
                type: Array
            },
            config: {
                type: Object
            },
            args: {
                type: Object
            },

        },
        data() {
            return {
                displayedPosts: this.posts,
                page: 1,
                pages: [],
                selectedDestination: '',
                selectedCategory: '',
                selectedSorting: '',
                sorting: '',
                search_val: '',
            }
        },
        methods: {
            searchcall: function (newValue) {
                let request = {
                    action:'listing_get_posts',
                        num: this.page,
                        args: this.args,
                        config: this.config
                };

                let self = this;

                j.post(TytoAjaxVars.ajaxurl, request).always(function(response){
                    response = JSON.parse(response); // Add this line
                    console.log(response);
                    if (request.config.pagination === 'numbers' || self.page === 1) {
                        self.displayedPosts = response.posts;
                    } else if (request.config.pagination === 'load_more') {
                        self.displayedPosts = self.displayedPosts.concat(response.posts);
                    }
                    self.setPages(response.pages_num);
                });
            },
            setPages(pages_number) {
                if (pages_number > 1) {
                    for (let index = 1; index <= pages_number; index++) {
                        this.pages.push(index);
                    }
                }
            },
        },
        created() {

        },
        computed: {

        },
        watch: {
            search_val: function(newValue){
                this.args.s = newValue;
                this.searchcall()
            },
            page: function(newValue){
                this.searchcall()
            },
            selectedDestination: function(newValue) {
                this.page = 1;
                this.args.tytocountries = newValue;
                this.searchcall()
            },
            selectedCategory: function(newValue) {
                this.page = 1;
                this.args.tytotags = newValue;
                this.searchcall()
            },
            selectedSorting: function(newValue) {
                if (newValue === 'price_desc') {
                    this.args.meta_key = 'tytoprice';
                    this.args.orderby = 'tytoprice_num';
                    this.args.order = 'DESC'
                } else if (newValue === 'price_asc') {
                    this.args.meta_key = 'tytoprice';
                    this.args.orderby = 'tytoprice_num';
                    this.args.order = 'ASC'
                }
                this.searchcall()
            }
        },
        mounted() {
            if (this.config.pagination === 'numbers') this.setPages(this.config.pages_num);
        },
        filters: {}
    }


</script>