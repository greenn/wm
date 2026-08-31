
const VMenu = _Page.component('v-menu');
const VContent = _Page.component('v-content');


console.log('=router=', { components: {
    'v-menu': VMenu,
    'v-content': VContent,
}});

const routes = [
    { path: '/', component: {
        template: '--routerDefTemplates--',
    } },

<? if (0) {?>


    { path: '/mo/:tab', component: MoMain },

    { path: '/patient/:page', component: PatientPage },
    { path: '/patient/:page/:uid([\\.\\|\\d]+)', component: PatientPage },
    { path: '/patient/:page/:uid([\\.\\|\\d]+)/:tab', component: PatientPage },
    { path: '/patient/:page/:tab', component: PatientPage },

    //{ path: '/about', component: About },
    //{ path: '/mo', component: { template: '#mo-test' } },
    //{ name: 'mo', path: '/mo2', component: _Page.component('mo-test') },
    //{ name: 'mo', path: '/mo3/:tab', component: _Page.component('mo-test') },
    { path: '/logout', component: {
        template: '',
        beforeRouteEnter(to, from, next) {
            console.log('logout/beforeRouteEnter', {
                this: this,
                "$('.nav-user-dropdown .btn-exit')": $('.nav-user-dropdown .btn-exit').length
            })
            //router.push('/');

            //$('.nav-user-dropdown .btn-exit').triggerHandler('click');
            // вызывается до подтверждения пути, соответствующего этому компоненту.
            // НЕ ИМЕЕТ доступа к контексту экземпляра компонента `this`,
            // так как к моменту вызова экземпляр ещё не создан!
        },
        beforeRouteUpdate(to, from, next) {
            console.log('logout/beforeRouteUpdate')
            // вызывается когда маршрут, что рендерит этот компонент изменился,
            // но этот компонент будет повторно использован в новом маршруте.
            // Например, для маршрута с динамическими параметрами `/foo/:id`, когда мы
            // перемещаемся между `/foo/1` и `/foo/2`, экземпляр того же компонента `Foo`
            // будет использован повторно, и этот хук будет вызван когда это случится.
            // Также имеется доступ в `this` к экземпляру компонента.
        },
        beforeRouteLeave(to, from, next) {
            console.log('logout/beforeRouteLeave')
            // вызывается перед переходом от пути, соответствующего текущему компоненту;
            // имеет доступ к контексту экземпляра компонента `this`.
        }
    } },


    //{ path: "*", component: PageNotFound },
    { path: '/:pathMatch(.*)*', component: PatientPage },
<? } ?>
]


const router = VueRouter.createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: VueRouter.createWebHashHistory(),
    routes: routes,
})

//< _Page.use(router)