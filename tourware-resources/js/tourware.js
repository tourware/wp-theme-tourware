import TravelListingItemLayout1 from "../vue/travel/listing/TravelListingItemLayout1";
import Vue from "vue";

Vue.component('travel-gallery', {
    template: '<h1>Pauli Bobby</h1>',
    props: ['config'],
    mounted: function () {
        console.log(JSON.parse(this.$attrs['data-config']))
        console.log(JSON.parse(this.$attrs['data-record']))
    }
});

Vue.component('travel-listing', {
    template: '<h1>Pauli Bobby</h1>',
    props: ['config'],
    mounted: function () {
    }
})

Vue.component('travel-listing-item-layout-1', TravelListingItemLayout1)
Vue.component('travel-listing-item-layout-2', TravelListingItemLayout2)
Vue.component('travel-listing-item-layout-3', TravelListingItemLayout3)
Vue.component("dtag", {
    props: {
        tag: String
    },
    functional: true,
    render(h, context) {
        return h(context.props.tag, context.data, context.children);
    }
});

jQuery( function( $ ) {
    if ( window.elementorFrontend ) {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ) {
            console.log($scope)
            // new Vue({
            //     el: $scope.find('.vue-widget-wrapper')[0]
            // });
        } );
    }
} );