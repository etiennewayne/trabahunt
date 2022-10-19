<template>
    <div>
        <div class="section">

            <div class="buttons">
                <a class="button is-primary" tag="a" href="/employer/company-add-edit">ADD COMPANY</a>
            </div>

            <div class="company-container">
                <div class="company-box">
                    <div class="company-title">
                        COMPANY TITLE
                    </div>
                    <hr>
                    <div class="company-desc">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Vitae quo cumque laboriosam autem accusantium vel quos quaerat voluptatum sunt adipisci?
                    </div>
                    <div class="company-footer">
                        ETIENNE WAYNE N. AMPARADO
                    </div>

                    <div class="buttons">
                        <b-button tag="a" class="button is-primary" href="/employer/company/1">VIEW COMPANY</b-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<style scoped>
    .company-container{
        display: flex;
    }

    .company-box{
        width: 300px;
        border: 1px solid gray;
        padding: 15px;
    }

    .company-title{
        font-weight: bold;
    }

    .company-footer{
        margin: 15px 0 15px 0;
        border-top: 1px solid rgb(207, 207, 207);
    }
</style>