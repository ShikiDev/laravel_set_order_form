<template>
    <div class="form-group">
        <label for="phone">Номер телефона</label>
        <masked-input id="phone" class="form-control" mask="8 (111) 111-11-11" @input="searchString = arguments[1]" placeholder="Ваш номер телефона"></masked-input>
        <button class="btn btn-primary" v-on:click="search">Поиск</button>
    </div>
</template>

<script>
    import MaskedInput from 'vue-masked-input'

    export default {
        components:{
            MaskedInput
        },
        data:function () {
            return {
                searchString: ''
            }
        },
        methods:{
            search:function () {

            }
        }
    }
</script>