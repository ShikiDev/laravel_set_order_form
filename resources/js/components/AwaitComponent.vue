<template>
    <div class="p-3 bg-white">
        <div class="alert alert-success alert-dismissible fade show" v-if="alertMessage !== ''">
            <strong>Внимание!</strong><span> {{alertMessage}}</span>
            <button type="button" class="close" data-dismiss="alert" v-on:click="" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="text-center py-2">
            <h3>Что вы выберите?</h3>
        </div>
        <div class="row pb-3 pl-3 pr-3">
            <div class="col">
                <div class="text-center">
                    <button class="btn btn-success btn-block" @click="showOrderForm">
                        Оформить заказ
                    </button>
                </div>
            </div>
            <div class="col">
                <div class="text-center">
                    <button class="btn btn-primary btn-block" @click="showFindForm">
                        Поиск заказов по телефону
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['alertMessage'],
        methods: {
            showOrderForm: function () {
                this.$parent.switchComponentTo('order');
            },
            showFindForm: function () {
                this.$parent.switchComponentTo('find');
            }
        }
    }
</script>