<template>
    <div class="ht-grid-item">
        <div class="tour-item">
            <div class="tour-head">
                <span v-if="post.badge" class="badge">{{post.badge}}</span>
                <a :href="post.link" class="tour-image">
                    <img :src="post.img_src"
                    :alt="post.title">
                </a>
                <div class="tour-attribute duration" v-if="post.days" v-html="config.icon_days + ' ' + post.days"></div>
                <div class="tour-attribute persons" v-if="post.persons" v-html="config.icon_persons + ' ' + post.persons"></div>
            </div>
            <div class="tour-content">
                <div v-if="post.destination" v-html="config.icon_destination + ' ' + post.destination" class="destination"></div>
                <a :href=post.link >
                    <component v-bind:is="post.title_tag" :class="['title', 'elementor-post__title']">{{post.title}}</component>
                </a>
                <div v-if="post.excerpt" v-html="post.excerpt" class="excerpt"></div>
                <div v-if="post.categories"  class="categories"><span v-for="category in post.categories" class="category">{{category}}</span></div>
                <div class="push"></div>
                <div v-if="post.scores"  class="scores">
                    <div v-for="score in post.scores" class="score" v-html="score"></div>
                </div>
                <div class="footer">
                    <div class="left">
                        <div v-if="post.price" class='price'>{{post.price}}</div>
                        <div v-if="post.flight" class='flight'>{{post.flight}}</div>
                    </div>
                    <div class="right">
                        <a v-if="config.read_more" :href="post.link" class="elementor-button read-more">{{config.read_more_text}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  props: {
    post: {
      type: Object
    },
      config: {
          type: Object
      }
  },

  mounted() {

  }
}


</script>