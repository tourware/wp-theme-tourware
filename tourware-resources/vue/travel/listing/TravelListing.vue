<template>
    <div class="advanced-tyto-list">
        <select v-if="config.filter_destinations" v-model="selectedDestination">
            <option v-for="destination in config.filter_destinations" :value="destination">{{destination}}</option>
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
                <a @click="page++" v-if="page < numberOfPages && numberOfPages > 1 || 1" class="elementor-button page-numbers">{{config.load_more_text}}</a>
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
                perPage: this.config.per_page,
                pages: [],
                selectedDestination: '',
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
                        self.displayedPosts = response;
                    } else if (request.config.pagination === 'load_more') {
                        self.displayedPosts = self.displayedPosts.concat(response);
                    }
                });
            },
            setPages() {
                if (this.numberOfPages > 1) {
                    for (let index = 1; index <= this.numberOfPages; index++) {
                        this.pages.push(index);
                    }
                }
            },
            paginate(posts) {
                let page = this.page;
                let perPage = this.perPage;
                let from;
                let to;
                if (this.config.pagination === 'numbers') {
                    from = (page * perPage) - perPage;
                    to = (page * perPage);
                } else if (this.config.pagination === 'load_more') {
                    from = 0;
                    to = (page * perPage);
                }
                return posts.slice(from, to);
            }
        },
        created() {

        },
        computed: {
            numberOfPages() {
                return Math.ceil(this.posts.length / this.perPage);
            }
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
            }
        },
        mounted() {
            if (this.config.pagination === 'numbers') this.setPages();
        },
        filters: {}
    }


</script>