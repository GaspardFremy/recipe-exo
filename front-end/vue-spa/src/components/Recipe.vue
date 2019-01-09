<template lang="html">
    <div class="section">
        <div class="container">
            <div class="card">
                <div class="columns">
                    <div class="column is-two-third">
                        <div class="card-image">
                            <figure class="image">
                                <img src="https://images.unsplash.com/photo-1473093295043-cdd812d0e601?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2250&q=80" alt="Placeholder image">
                            </figure>
                        </div>
                    </div>

                    <div class="column auto">

                        <div class="card-content">
                            <p class="title">
                                {{recipe.title}}
                            </p>

                            <div class="media-content">
                                <p class="subtitle"> by  {{recipe.author}}</p>
                                <p>{{recipe.description}}</p>

                                <div class="serving">
                                    <p class="is-size-5 has-text-weight-semibold">Ingredients for {{recipe.serving}} person</p>

                                    <div class="add_serving">
                                        <p class="has-text-weight-semibold">add serving  &#x2063; &#x2063;</p>
                                        <b-select v-model="recipe.serving">
                                            <option
                                                v-for="index in 15"
                                                :key="index">
                                                {{ index }}
                                            </option>
                                        </b-select>
                                    </div>
                                </div>
                                <p v-for="item in recipe.ingredients">{{item.name}} {{(item.quantity * recipe.serving)}} {{item.unity}}</p>
                            </div>

                            <div class="media-content recipe-footer">

                                <router-link :to="{ name: 'category', params: { category_id: recipe.category_id}}">
                                    <a v-bind:class="getClass()" class="button is-outlined">{{recipe.category_name}}</a>
                                </router-link>

                                <span>{{ recipe.created_at | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from 'axios';

export default {
    name: 'recipe',
    props: ['id'],

    data () {
        return {
            recipe : null,
            serving : 2,
            endpoint : 'http://localhost/cours/recipeAPI/recipe/' + this.id
        }
    },

    created() {
        this.getRecipe();
    },

    methods: {

        getRecipe() {
            axios.get(this.endpoint)
                .then(response=> {
                    this.recipe = response.data;
                    console.log(response.data);
                    this.getServingPerOne();
                })
                .catch(error => {
                    console.log('err :');
                    console.log(error);
                })
        },
        getServingPerOne(){
            const values = Object.values(this.recipe.ingredients)
            console.log(values)

            let serving = this.recipe.serving;

            for (let i=0; i < values.length ; i++) {
                values[i].quantity = (values[i].quantity / serving)
            }
        },
        getClass(){
            switch (this.recipe.category_name) {
            case 'starter':
                return 'is-primary'
                break;
            case 'meal':
                return 'is-success'
                break;
            case 'desert':
                return 'is-info'
                break;
            break;
            default:
                return 'is-info'
                break;
            }
        }
    }
}
</script>

<style lang="css" scoped>
.column {
    padding: 0;
}
.card-content {
    flex: auto;
}
.recipe-footer {
    margin-top: 5%;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.card {
    -webkit-transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    border-radius: 7px;
}

.card:hover {
    transform: scale(1, 1);
    box-shadow: 0 2px 3px rgba($black, 0.1), 0 0 0 1px rgba($black, 0.1);
}

figure {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    border-top-right-radius: 0px;
    overflow: hidden;

}

.serving {
    margin-top: 20px;
    display : flex;
    justify-content: space-between;
}

.add_serving{
    display : flex;
    align-items: center;
    justify-content: center;
}


.add_serving:first-child {
    padding-right: 10px;
    color: red;
}


</style>
