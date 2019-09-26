<template>
    <div id="order_form_block" class="p-3 bg-white">
        <button class="btn btn-light mb-3" v-on:click="goBackBtn">Назад</button>
        <h4>Оформить заказ</h4>
        <div class="alert alert-danger alert-dismissible fade show" v-if="isErrorAlert == true">
            <strong>Внимание!</strong>
            <p v-if="isResponseError == true">{{responseErrorMessage}}</p>
            <p v-else>Некоторые поля не заполнены или заполнены не до конца.</p>
            <button type="button" class="close" data-dismiss="alert" v-on:click="isErrorAlert=false" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <hr>
        <div>
            <div class="form-group">
                <label for="name">Имя</label>
                <input class="form-control" type="text" v-model="clientName" id="name" v-on:change="onChangeField">
            </div>
            <div class="form-group">
                <label for="phone">Телефон</label>
                <masked-input id="phone" class="form-control" mask="8 (111) 111-11-11"
                              @input="selectedPhone = arguments[1]" placeholder="Ваш номер телефона"
                              v-on:change="onChangeField"></masked-input>
            </div>
            <div class="form-group">
                <label for="tariffs">Тариф</label>
                <select class="form-control" v-model="selectedTariff" id="tariffs" v-on:change="showDeliveryDays">
                    <option value="0" selected>Не выбран</option>
                    <option v-for="tariff in tariffs" v-bind:value="tariff.id">{{tariff.name}} ({{tariff.price}} руб.)
                    </option>
                </select>
            </div>
            <div class="form-group" v-if="isDeliveryDaysShow == true">
                <label for="delivery_days">Первый день доставки</label>
                <select name="first_date" class="form-control" v-model="selectedFirstDeliveryDate" id="delivery_days"
                        v-on:change="onChangeField">
                    <option value="" selected>Не выбран</option>
                    <option v-for="days in delivery_days" v-bind:value="days">{{days}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Адрес</label>
                <input type="text" id="address" v-model="clientAddress" class="form-control">
            </div>
            <button class="btn btn-success" @click="saveOrder">Оформить</button>
        </div>
    </div>
</template>

<script>
    import MaskedInput from 'vue-masked-input'

    export default {
        components: {
            MaskedInput
        },
        data: function () {
            return {
                isDeliveryDaysShow: false,
                isResponseError: false,
                isErrorAlert: false,
                delivery_days: [],
                responseErrorMessage: '',
                clientName: '',
                selectedPhone: '',
                selectedTariff: 0,
                selectedFirstDeliveryDate: '',
                clientAddress: '',
                postBody: {},
                errorList: [],
            }
        },
        mounted() {
        },
        props: ['tariffs'],
        methods: {
            showDeliveryDays: function (event) {
                this.onChangeField(event);

                let tariffs = this.tariffs;
                let tariff_id = event.target.value;
                let delivery_days = [];
                if (tariff_id == 0 || tariff_id == null || tariff_id == undefined) {
                    if (this.isDeliveryDaysShow) {
                        this.delivery_days = [];
                        this.isDeliveryDaysShow = false;
                    }
                    return 0;
                }
                for (let i in tariffs) {
                    if (tariffs[i].id == tariff_id) {
                        delivery_days = tariffs[i].delivery_days;
                    }
                }

                this.delivery_days = delivery_days;
                this.isDeliveryDaysShow = true;
            },
            saveOrder: function (event) {
                this.isErrorAlert = false;

                if (this.clientName == '') this.errorList.push('name');
                if (this.selectedPhone == '') this.errorList.push('phone');
                if (this.selectedTariff == 0) this.errorList.push('tariffs');
                if (this.selectedFirstDeliveryDate == '') this.errorList.push('delivery_days');

                if (this.selectedPhone.length > 0 && this.selectedPhone.length < 10) this.errorList.push('selected_phone');

                if (this.errorList.length > 0) {
                    this.showErrors();
                    return 0;
                }

                if (this.selectedPhone.charAt(0) != '8' && this.selectedPhone.length == 10) this.selectedPhone = '8' + this.selectedPhone;

                this.postBody.tariff_id = this.selectedTariff;
                this.postBody.first_date = this.selectedFirstDeliveryDate;
                this.postBody.address = this.clientAddress;

                axios.post('/orders', {
                    name: this.clientName,
                    phone: this.selectedPhone,
                    tariff_id: this.selectedTariff,
                    first_date: this.selectedFirstDeliveryDate,
                    address: this.clientAddress
                }).then(
                    response => {
                        if (response.data.message !== null) {
                            if (response.data.status == 'success') {
                                this.$parent.switchComponentTo('await', 'Заказ успешно оформлен');
                            } else if (response.data.status == 'error') {
                                this.responseErrorMessage = response.data.message;
                                this.isResponseError = true;
                            }
                        }
                    }
                )
            },
            showErrors: function () {
                this.isErrorAlert = true;

                for (let index in this.errorList) {
                    if (document.getElementById(this.errorList[index]) != null)
                        document.getElementById(this.errorList[index]).classList.add('is-invalid');
                }
                this.errorList = [];
            },
            onChangeField: function (event) {
                if (event.target.classList.contains('is-invalid'))
                    event.target.classList.remove('is-invalid');
                return true;
            },
            goBackBtn: function () {
                this.$parent.switchComponentTo('await');
            }
        }
    }
</script>
