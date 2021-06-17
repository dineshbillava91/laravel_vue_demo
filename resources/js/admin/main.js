import store from './store';
import router from './routes/router';
import App from './views/App';
import mixin from '../custom';

Vue.mixin(mixin);

new Vue({
	el: '#app',
	store,
	router,
	render: h => h(App)
});
