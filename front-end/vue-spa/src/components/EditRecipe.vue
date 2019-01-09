<template>
    <section>
        <div class="container">

            <h4 class="recipe-title">Edit your recipe</h4>


            <b-field horizontal label="Title">

                <div class="field is-grouped">

                    <b-input v-model='recipe.title' name="title" placeholder="Italian Sausage Tortellini Bake" ></b-input>

                    <b-field horizontal label="Author">
                        <b-input v-model='recipe.author' name="author" placeholder="Jon Doe" ></b-input>
                    </b-field>
                </div>
            </b-field>

            <b-field horizontal label="Category" >
                <div class="field is-grouped">
                    <b-select v-model='recipe.category_id' placeholder="Plat">
                        <option value="1">Starter</option>
                        <option value="2">Meal</option>
                        <option value="3">Desert</option>
                    </b-select>

                    <b-field horizontal label="serving" >
                        <b-select v-model="recipe.serving">
                            <option
                                v-for="index in 15"
                                :key="index">
                                {{ index }}
                            </option>
                        </b-select>
                    </b-field>
                </div>
            </b-field>

            <b-field horizontal label="Description">
                <b-input v-model='recipe.description' placeholder="Delicious Italian tortellini dish will have you coming back for seconds." type="textarea"></b-input>
            </b-field>

            <b-field horizontal label="Add an Ingredient">

                <div class="field is-grouped">

                    <b-autocomplete
                    v-model="name"
                    ref="autocomplete"
                    :data="filteredDataArray"
                    placeholder="ex: banane"
                    @select="option => selected = option">
                        <template slot="header">
                            <a @click="showAddFruit">
                                <span> Add new... </span>
                            </a>
                        </template>
                        <template slot="empty">No results for {{name}}</template>
                    </b-autocomplete>

                    <b-field horizontal label='quantity'>
                        <input v-model='quantity' class="input" type="text" placeholder="ex: 200">
                    </b-field>

                    <b-field horizontal label='unity'>
                        <b-select v-model='unity' placeholder="ex: grams" required>
                            <option value="Unit">Unit</option>
                            <option value="kg">kg</option>
                            <option value="grams">grams</option>
                            <option value="Liter">Liter</option>
                            <option value="ml">ml</option>
                        </b-select>
                    </b-field>

                    <b-field horizontal>
                        <a class="button is-outlined is-info" @click='addIngredient()'>
                          <span class="icon is-large">
                            <i class="fas fa-plus"></i>
                          </span>
                          <span>Add ingredient</span>
                        </a>
                    </b-field>
                </div>
            </b-field>

            <b-field horizontal>
                <p class="control"><b>Selected ingredients :</b> <span v-if="ingredients.length <= 0"> None</span></p>
            </b-field>

            <b-field horizontal v-for="(item, index) in ingredients">
                <div class="field is-grouped">
                        <span>{{ item.name }} {{ item.quantity }} {{ item.unity}} &#x2063; &#x2063;</span>
                        <a class="button is-rounded is-small is-danger is-outlined"  @click='deleteIngredient(index)'>
                            <span class="icon is-danger">
                              <i class="fas fa-times"></i>
                            </span>
                        </a>
                </div>
            </b-field>

            <b-field horizontal>
                <p class="control">
                    <button class="button is-primary" @click="editRecipe(recipe.id)">
                    Edit recipe
                    </button>
                </p>
            </b-field>

            <transition name="fade">
                <div horizontal class="notification is-danger" v-if='message' v-on:click="message = !message">
                  <button class="delete"></button>
                    {{message}}
                </div>
            </transition>

        </div>
    </section>
</template>

<script>
import Router from 'vue-router';
import axios from 'axios';



export default {

    props: ['id'],

    data () {
        return {
            author: null,
            title:  null,
            description:  null,
            category_id:  null,
            recipe : null,
            message: null,
            endpoint_get_recipe : 'http://localhost/cours/recipeAPI/recipe/' + this.id,
            endpoint_edit_recipe : 'http://localhost/cours/recipeAPI/recipe/update',
            data : ['Orange','Apple','Banana','Pear','Lemon','Strawberry','Kiwi'],
            name: '',
            quantity: '',
            unity: '',
            selected: null,
            serving: 1,
            ingredients : []
        }
    },

    created() {
        this.getRecipe();
    },

    methods: {
        getRecipe() {
            axios.get(this.endpoint_get_recipe)
                .then(response=> {
                    this.recipe = response.data;
                    this.ingredients = response.data.ingredients;
                })
                .catch(error => {
                    console.log('err :');
                    console.log(error);
                })
        },
        addIngredient(){
            let ingredient = {
                'name' : this.name,
                'quantity' : this.quantity,
                'unity' : this.unity
            };
            this.ingredients.push(ingredient);
        },
        deleteIngredient(index){
            console.log(index);
            this.ingredients.splice(index, 1);
        },
        showAddFruit() {
                this.$dialog.prompt({
                    message: `new product`,
                    inputAttrs: {
                        placeholder: 'e.g. Watermelon',
                        maxlength: 20,
                        value: this.name
                    },
                    confirmText: 'Add',
                    onConfirm: (value) => {
                        this.data.push(value)
                        this.$refs.autocomplete.setSelected(value)
                    }
                })
        },
        editRecipe(){
            let payload = {
                'author' : this.recipe.author,
                'title' : this.recipe.title,
                'description' : this.recipe.description,
                'category_id' : this.recipe.category_id,
                'ingredients' : this.ingredients,
                'serving' : this.serving,
                'id' : this.id
            };

            console.log(payload);

            this.axios.put(this.endpoint_edit_recipe, payload).then((response) => {
                console.log('response');
                if (response.data.success === 'true'){
                    this.$toast.open({
                    message: 'Recipe updated',
                    type: 'is-success'})
                   this.$router.push({ name: 'recipe', params: { id: response.data.id } })
                } else if (response.data.message !== null){
                   this.message = response.data
                }
            });

        }
    },
    computed: {
        filteredDataArray() {
        return this.data.filter((option) => {
            return option
                .toString()
                .toLowerCase()
                .indexOf(this.name.toLowerCase()) >= 0
            })
        }
    },
}
</script>

<style lang="css" scoped>
    section {
        margin-top: 50px;
    }

    h4 {
        margin-bottom: 50px;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }

    .recipe-title{
        padding-top: 60px;
    }
</style>
