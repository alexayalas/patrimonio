
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
window.Vue = require('vue');

import VueRouter from 'vue-router'
import VModal from 'vue-js-modal'
import VuejsDialog from 'vuejs-dialog'
import './interceptors'
import VueGoodTable from 'vue-good-table'
import 'vue-good-table/dist/vue-good-table.css'
import ToggleButton from 'vue-js-toggle-button'
import underscore from 'vue-underscore'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
import VueSweetalert2 from 'vue-sweetalert2'

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.use(VueRouter)
Vue.use(VueGoodTable)
Vue.use(VModal)
Vue.use(VuejsDialog)
Vue.use(ToggleButton)
Vue.use(underscore)
Vue.use(Loading);
Vue.component('loading', Loading)
Vue.use(VueSweetalert2)
