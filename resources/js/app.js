import { App, plugin } from '@inertiajs/inertia-vue';
import Vue from 'vue';
import { InertiaProgress } from '@inertiajs/progress';
import KProgress from 'k-progress';
import VueCarousel from 'vue-carousel';
import VueGraph from 'vue-graph';
import VuejsDialog from 'vuejs-dialog';
import VuejsDialogMixin from 'vuejs-dialog/dist/vuejs-dialog-mixin.min.js';

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
});

InertiaProgress.init();

Vue.use(plugin)
Vue.component('k-progress', KProgress);
Vue.use(VueCarousel);
Vue.use(VueGraph);
Vue.use(VuejsDialog);

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
      
      if(arg == 'admin' && (user.perspective == 1 || user.perspective == 2) ) return true; 
      if(arg == 'covid' && (user.perspective == 1) ) return true; 
      if(arg == 'vaccination' && user.perspective == 1 && user.user_type != 'employee') return true;
      if(arg == 'save_case' && user.perspective == 1 && user.user_type == 'admin') return true; 
      if(arg == 'save_post' && user.perspective == 1) return true;
      if(arg == 'save_news' && user.perspective == 3) return true;
    },
  }
})


const el = document.getElementById('app')

new Vue({
	data: {
	    // route: window.location.href.replace(window.location.pathname, '')
      route: window.location.protocol + '//' + window.location.host
	},
  render: h => h(App, {
    props: {
      initialPage: JSON.parse(el.dataset.page),
      resolveComponent: name => require(`./Pages/${name}`).default,
    },
  }),
}).$mount(el)