import VueRouter from 'vue-router';
import { createSandbox } from 'vue-kindergarten';
import { sync } from 'vuex-router-sync';

import routes from './routes';
import RouteGoverness from '../acl/GuestGoverness';

import authPerimeter from '../perimeters/auth';

const router = new VueRouter({mode: 'history', base: '/app/', routes,});

import store from '../store/index';

const unsync = sync(store, router);

//const child = store.state.user.user;

//middleware

router.beforeEach((to, from, next) => {

  to.matched.some((routeRecord) => {
    const perimeter = routeRecord.meta.perimeter;
    const Governess = routeRecord.meta.governess || RouteGoverness;
    const action = routeRecord.meta.perimeterAction || 'route';

    if (perimeter) {
      const sandbox = createSandbox(store.state.user.user, {
        governess: new Governess(),

        perimeters: [
          perimeter,
        ],
      });

      return sandbox.guard(action, { to, from, next });
    }

    return next();
  });
});


router.beforeEach(function(to, from, next){
  store.dispatch('alert/dismiss');
  //store.dispatch('nav/showLoading');
  next();
});


router.afterEach(function(to, from){
//  store.dispatch('nav/hideLoading');
});

export default router;
