import { App, plugin } from '@inertiajs/inertia-vue'
import Vue from 'vue'
import { InertiaProgress } from '@inertiajs/progress'
import KProgress from 'k-progress';
import VueCarousel from 'vue-carousel';
import VueGraph from 'vue-graph'

InertiaProgress.init({
  // The delay after which the progress bar will
  // appear during navigation, in milliseconds.
  delay: 0,

  // The color of the progress bar.
  color: '#29d',

  // Whether to include the default NProgress styles.
  includeCSS: true,

  // Whether the NProgress spinner will be shown.
  showSpinner: true,
})

Vue.use(plugin)

InertiaProgress.init()

Vue.component('k-progress', KProgress);
Vue.use(VueCarousel);
Vue.use(VueGraph);

Vue.mixin({
  methods: {
    validationError(field, errors) {
      if(errors) {
        if(errors.hasOwnProperty(field)) {
          return Array.isArray(errors[field]) ? errors[field][0] : errors[field];
        }
      }

      return null;
    },

    isAuthorize(arg, user) {
      if(!user) return false;
      
      if(arg == 'save_case' && user.perspective == 1) return true;


    }
  }
})


const el = document.getElementById('app')

new Vue({
	data: {
	    route: window.location.href.replace(window.location.pathname, '')
	},
  render: h => h(App, {
    props: {
      initialPage: JSON.parse(el.dataset.page),
      resolveComponent: name => require(`./Pages/${name}`).default,
    },
  }),
}).$mount(el)