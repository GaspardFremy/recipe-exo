<template lang="html">
    <div>
        <nav class="navbar" role="navigation" aria-label="main navigation">

        <div class="navbar-brand">
        <a class="navbar-item" href="./index.html">
          <H1>Recettes</H1>
        </a>

        <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
          <a class="navbar-item">Toutes les recettes</a>

          <a class="navbar-item">
            Ajouter une recette
          </a>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              catégories
            </a>

            <div class="navbar-dropdown">
              <a class="navbar-item">
                Entrées
              </a>
              <a class="navbar-item">
                Plats
              </a>
              <a class="navbar-item">
                Desserts
              </a>
              <hr class="navbar-divider">
              <a class="navbar-item">
                Ajouter une catégorie
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
    </div>

</template>

<script>

export default {
    name : 'menunav'
}
</script>

<style lang="css">
</style>
