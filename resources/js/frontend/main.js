import store from './store';
import router from './routes/router';
import App from './views/App'

new Vue({
	el: '#app',
	store,
	router,
	render: h => h(App)
});
