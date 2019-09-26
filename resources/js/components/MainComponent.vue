<template>
    <await-component v-if="isAwait == true"></await-component>
    <form-component v-else-if="isOrder == true" :tariffs="tariffs" :alertMessage="alertMessage"></form-component>
    <find-component v-else-if="isFind == true"></find-component>
</template>

<script>
    import FormComponent from './FormComponent.vue'
    import FindComponent from './FindComponent.vue'
    import AwaitComponent from './AwaitComponent.vue'

    export default {
        components: {
            'form-component': FormComponent,
            'find-component': FindComponent,
            'await-component': AwaitComponent
        },
        data: function () {
            return {
                isAwait: true,
                isOrder: false,
                isFind: false,
                alertMessage: ''
            }
        },
        props: ['tariffs'],
        methods: {
            switchComponentTo(componentName, message) {
                console.log(componentName);

                switch (componentName) {
                    case 'await':
                        this.isAwait = true;
                        this.isOrder = false;
                        this.isFind = false;

                        if (message !== null || message !== undefined || message !== '') this.alertMessage = message;

                        break;
                    case 'find':
                        this.isAwait = false;
                        this.isOrder = false;
                        this.isFind = true;
                        break;
                    case 'order':
                        this.isAwait = false;
                        this.isOrder = true;
                        this.isFind = false;
                        break;
                    default:
                        this.isAwait = true;
                        this.isOrder = false;
                        this.isFind = false;
                }

                console.log(this.isAwait + ' ' + this.isOrder + ' ' + this.isFind);
            }
        }
    }
</script>