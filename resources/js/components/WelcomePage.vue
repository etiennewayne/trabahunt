<template>
    <div>
        <div class="section">
            <div class="slogan">
                Hunt the best job today!
            </div>
            <div class="slogan">
                Hunt the best people for your job!
            </div>
        </div>


        <div class="section">
            <div class="">
                <b-field position="is-centered">
                    <b-input class="search-text" type="input" rounded size="is-large" icon-right="magnify" placeholder="Job Title, Company name.."></b-input>
                    <b-input class="search-text" type="input" rounded size="is-large" icon-right="head-lightbulb-outline" placeholder="Job Type.."></b-input>
                    <p class="control">
                        <button class="button is-rounded is-primary is-large">Search</button>
                    </p>
                </b-field>
            </div>
            
        </div>


        

    </div> <!--root div-->
</template>

<script>
export default {
    props: ['propUser'],
    data(){
        return{
            locale: undefined,
            isModalActive: false,
        }

    },

    methods: {

    },

    mounted() {


    },


}
</script>

<style scoped>


    .slogan{
        font-weight: bold;
        font-size: 3em;
        color: rgb(0, 100, 0);
        text-align: center;
    }
   

    @media only screen and (max-width: 1024px) {

    }

    @media only screen and (max-width: 768px) {
        .main-text-container{
            top: 230px;
            width: 100%;
            margin: 0;
        }
    }

    @media only screen and (max-width: 480px) {
        .main-text-container{
            padding: 15px;
        }
        .main-title{
            font-size: 1.2em;
        }

        .main-subtitle{
            font-size: .8em;
        }

    }





</style>
