<template>
    <div class="p-3 bg-white">
        <div class="alert alert-success" v-if="successMessage == true">
            <strong>Внимание!</strong><span>{{alertMessage}}</span>
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
        data: function () {
            return {
                successMessage: false,
                alertMessage: ''
            }
        },
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