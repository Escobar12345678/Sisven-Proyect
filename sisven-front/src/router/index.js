import { createRouter, createWebHashHistory } from "vue-router";

import Home from "../views/HomeView.vue";
import Customers from "../views/Customers.vue";
import NewCustomer from "../components/Customers/NewCustomer.vue";
import EditCustomer from "../components/Customers/EditCustomer.vue";

import Categories from "../views/Categories.vue"; 
import NewCategories from "../components/Categories/NewCategories.vue"; 
import EditCategories from "../components/Categories/EditCategories.vue"; 

import PayMode from "../views/PayMode.vue";
import NewPayMode from "../components/PayMode/NewPayMode.vue";
import EditPayMode from "../components/PayMode/EditPayMode.vue";

// NUEVOS IMPORTS PARA PRODUCTS
import Products from "../views/Products.vue";
import NewProducts from "../components/Products/NewProducts.vue";
import EditProducts from "../components/Products/EditProducts.vue";

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/customers",
    name: "Customers",
    component: Customers,
  },
  {
    path: "/customers/new",
    name: "NewCustomer",
    component: NewCustomer,
  },
  {
    path: "/customers/:id/",
    name: "EditCustomer",
    component: EditCustomer,
  },
  {
    path: "/categories",
    name: "Categories",
    component: Categories,
  },
  {
    path: "/categories/new",
    name: "NewCategories",
    component: NewCategories,
  },
  {
    path: "/categories/:id/",
    name: "EditCategories",
    component: EditCategories,
  },
  {
    path: "/paymodes",
    name: "PayModes",
    component: PayMode,
  },
  {
    path: "/paymodes/new",
    name: "NewPayMode",
    component: NewPayMode,
  },
  {
    path: "/paymodes/:id/",
    name: "EditPayMode",
    component: EditPayMode,
  },

  // RUTAS DE PRODUCTS
  {
    path: "/products",
    name: "Products",
    component: Products,
  },
  {
    path: "/products/new",
    name: "NewProducts",
    component: NewProducts,
  },
  {
    path: "/products/:id/",
    name: "EditProducts",
    component: EditProducts,
  },

  {
    path: "/about",
    name: "About",
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/AboutView.vue"),
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;
