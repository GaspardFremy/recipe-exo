<template lang="html">
    <div class="section">
        <div class="container is-fluid">
            <h4>{{this.title}}</h4>
            <div class="columns is-multiline" >
                <div class="column is-one-third"
                    v-for="recipe in recipes"
                    active-class="is-active">
                    <div class="card">
                        <div class="card-image">
                            <figure class="image is-3by2">
                                <img src="https://images.unsplash.com/photo-1473093295043-cdd812d0e601?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2250&q=80" alt="Placeholder image">
                        </figure>
                        </div>
                        <div class="card-content">
                            <p class="title link">
                                <router-link :to="{ name: 'recipe', params: { id: recipe.id }}">{{recipe.title}}</router-link>
                            </p>

                            <div class="media-content">
                                <p class="subtitle">{{recipe.author}}</p>
                                <p>{{recipe.description}}</p>
                            </div>

                        </div>
                            <footer class="card-footer">
                            <p class="card-footer-item" @click="edit(recipe.id)">
                                <a href="#">edit</a>
                            </p>
                            <p class="card-footer-item" @click="confirm(recipe.id)">
                                <a href="#">delete</a>
                            </p>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name  : 'Home',
    props : ['category_id'],
    watch : {
        category_id: function() { this.refreshRecipes();}
    },
    data () {
        return {
            title: null,
            recipes : null,
            endpoint_all_recipes : 'http://localhost/cours/recipeAPI/recipe',
            endpoint_recipes_by_category : 'http://localhost/cours/recipeAPI/recipe/category/',
            delete_endpoint : 'http://localhost/cours/recipeAPI/recipe/delete/'
        }
    },

    created() {
        this.refreshRecipes();
    },

    methods: {
        refreshRecipes(){
            if(this.category_id == null){
                this.recipes = null;
                this.getAllRecipes();
                this.title = "All recipes";
            } else {
                switch (this.category_id) {
                  case 1:
                    this.recipes = null;
                    this.getRecipesByCategory();
                    this.title = "Starters";
                    break;
                  case 2:
                    this.recipes = null;
                    this.title = "Meals";

                    this.getRecipesByCategory();
                  case 3:
                    this.recipes = null;
                    this.getRecipesByCategory();
                    this.title = "Deserts";
                    break;
                  default:
                    this.recipes = null;
                    this.getAllRecipes();
                    this.title = "All recipes";
                }
            }
        },

        getAllRecipes() {
            this.recipes = null;
            axios.get(this.endpoint_all_recipes)
                .then(response=> {
                    this.recipes = response.data.data;
                    console.log(response.data);
                })
                .catch(error => {
                    console.log('err :');
                    console.log(error);
                })
        },

        getRecipesByCategory() {
            this.recipe = null;
            axios.get(this.endpoint_recipes_by_category + this.category_id)
                .then(response=> {
                    this.recipes = response.data.data;
                    console.log(response.data);
                })
                .catch(error => {
                    console.log('err :');
                    console.log(error);
                })
        },

        edit(id) {
            this.$router.push({ name: 'editrecipe', params: { id: id } })
        },

        deleteRecipe(id) {
            axios.delete(this.delete_endpoint + id)
                .then(response=> {
                    this.$toast.open({
                    message: 'Recipe deleted',
                    type: 'is-success'})
                    this.getAllRecipes();
                })
                .catch(error => {
                    console.log('err :');
                    console.log(error);
                })
        },

        confirm(id) {
            //need to prevent modal from scrolling up
            // document.body.classList.add("modal-open");
            this.$dialog.confirm({
                message: 'Are you sure ?',
                type: 'is-danger',
                onConfirm: () => this.deleteRecipe(id)
            })
        }

    }
}
</script>

<style lang="css">
.container {
    margin-top: 20px;
}

h4 {
    margin-bottom: 50px;
    font-weight: bold;
    font-size: 1.2rem;
}

.card {
    -webkit-transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    border-radius: 7px;
}

.card:hover {
    transform: scale(1.028, 1.028);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

figure {
    overflow: hidden;
    border-top-left-radius: 7px;
    border-top-right-radius: 7px;
}

.title a{
    color: #42b983;
}

html, body {
    height:100%;
}

.modal-open {
    overflow: hidden;
    background-color: red;
}

</style>
