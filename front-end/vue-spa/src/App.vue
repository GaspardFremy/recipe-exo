<template>
    <div id="app">

        <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">

        <div class="navbar-brand">
        <a class="navbar-item" href="./index.html">
            <router-link v-bind:to="'/home'"><H1>Recettes</H1></router-link>
        </a>

        <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
          <a class="navbar-item"><router-link v-bind:to="'/home'">All recipes</router-link></a>

          <a class="navbar-item">
            <router-link v-bind:to="'/newrecipe'">Add a new recipe</router-link>
          </a>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              categories
            </a>

            <div class="navbar-dropdown">
              <a class="navbar-item">
                  <router-link :to="{ name: 'category', params: { category_id: 1}}">Starter</router-link>
              </a>
              <a class="navbar-item">
                  <router-link :to="{ name: 'category', params: { category_id: 2}}">Meal</router-link>
              </a>
              <a class="navbar-item">
                  <router-link :to="{ name: 'category', params: { category_id: 3}}">Desert</router-link>
              </a>
            </div>
          </div>
        </div>

        <div class="navbar-end">
          <div class="navbar-item">
            <div class="buttons">
              <a class="button is-primary">
                <strong>Sign up</strong>
              </a>
              <a class="button is-light">
                Log in
              </a>
            </div>
          </div>
        </div>
        </div>
        </nav>
        <div class="nav">
            <router-view></router-view>
        </div>

    </div>
</template>

<script>
import MenuNav from './components/MenuNav.vue'
import Home from './components/Home.vue'
import Recipe from './components/recipe.vue'
import axios from 'axios'

export default {

    name: 'app',

    components: {
        MenuNav,
        Home,
    },

    }
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 10px;
}


body {
    min-height: 100%;
    margin: 0;
    padding: 0;
    background-color: #F5F5F5;
}
html {
    height: 100%;
    background-color: #F5F5F5;

}


h1, h2 {
    font-family: 'Source Serif Pro', serif;
    font-size: 3rem;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}

a {
    color: #2f2f2f;
}

a:hover {
  color: #42b983;
}

body {
    padding-top: 50px;

}

.nav {
    margin-top: 50px;
}


</style>
