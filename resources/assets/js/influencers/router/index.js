import Vue from 'vue';
import Router from 'vue-router';

/*Instala el plugin de vue-router*/
Vue.use(Router);

import Home from '../Home.vue';
import Condiciones from '../Condiciones.vue';

const router = new Router({
    /*mode: 'history',*/
	routes: [
        { path: '/', name: 'home',component: Home },    
        { path: '/condiciones', name: 'condiciones',component: Condiciones },   
    ]
});

export default router;