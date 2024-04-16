import MainLayout from 'layouts/MainLayout.vue'
import IndexPage from 'pages/IndexPage.vue'
import Login from 'pages/Login.vue'
import Cliente from 'pages/Cliente.vue'
import Pantalla from 'pages/Pantalla.vue'
import Ventanilla from 'pages/Ventanilla.vue'

const routes = [
  {
    path: '/',
    component: MainLayout,
    children: [{ path: '', component: IndexPage.vue }],
  },
  {
    path: '/login',
    component: Login
  },
  {
    path: '/cliente',
    component: Cliente
  },
  {
    path: '/pantalla',
    component: Pantalla
  },
  {
    path: '/ventanilla',
    component: Ventanilla, meta: { requiresAuth: true }
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
