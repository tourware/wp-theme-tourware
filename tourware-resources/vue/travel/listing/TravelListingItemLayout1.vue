<template>
    <div class="ht-grid-item">
        <div class="tour-item">
            <div class="tour-head">
                {{post.price_html}}
                <a :href="post.link" class="tour-image">
                    <img :src="post.img_src"
                    :alt="post.title">
                </a>
                {{post.badge_html}}
            </div>
            <div class="tour-content">
                <a :href=post.link >
                    <component v-bind:is="post.title_tag" :class="['title', 'elementor-post__title']">{{post.title}}</component>
                </a>
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
  },

  mounted() {

  }
}


</script>