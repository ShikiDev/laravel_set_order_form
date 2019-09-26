<template>
    <div class="p-3 bg-white">
        <button class="btn btn-light mb-3" v-on:click="goBackBtn">Назад</button>
        <div class="row mb-2 border-bottom box-shadow">
            <div class="col">
                <div class="form-group">
                    <label for="phone">Номер телефона</label>
                    <masked-input id="phone" class="form-control" mask="8 (111) 111-11-11"
                                  @input="searchString = arguments[1]" placeholder="Ваш номер телефона"></masked-input>
                </div>
                <button class="btn btn-primary mb-2" v-on:click="search">Поиск</button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="py-2" v-if="isResponseFilled == true">
                    <div>
                        <span>Имя: {{responseData.client.name}}</span><br>
                        <span>Телефон: {{responseData.client.phone}}</span><br>
                        <span>Время создания: {{responseData.client.created_at}}</span><br>
                    </div>
                    <hr>
                    <table class="table">
                        <thead>
                        <th>id</th>
                        <th>Название тарифа</th>
                        <th>Цена</th>
                        <th>Адрес</th>
                        <th>Дата первой доставки</th>
                        <th>Дата заказа</th>
                        </thead>
                        <tbody>
                        <tr v-for="order in responseData.client_orders">
                            <td>{{order.id}}</td>
                            <td>{{order.tariff_name}}</td>
                            <td>{{order.tariff_price}}</td>
                            <td>{{order.address}}</td>
                            <td>{{order.first_date}}</td>
                            <td>{{order.order_date}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="py-2" v-else>
                    <h5>Результаты поиска</h5>
                    <span class="card-text">Нет данных. Попробуйте поискать еще раз, либо введите другой номер</span>
                </div>
            </div>
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
                searchString: '',
                isResponseFilled: false,
                responseData: []
            }
        },
        methods: {
            search: function () {
                if (this.searchString.charAt(0) != '8' && this.searchString.length == 10) this.searchString = '8' + this.searchString;

                axios.get('/orders/find', {
                    params: {
                        string: this.searchString
                    }
                }).then(response => {
                    if (response.data.message !== null) {
                        console.log(response);
                        if (response.data.status == 'success') {
                            this.responseData = response.data.data;
                            this.isResponseFilled = true;
                        } else if (response.data.status == 'error') {
                            this.isResponseFilled = false;
                        }
                    }
                });
            },
            goBackBtn: function () {
                this.$parent.switchComponentTo('await');
            }
        }
    }
</script>