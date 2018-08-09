<template>
    <transition
            enter-active-class="animated fadeIn"
            leave-active-class="animated fadeOut"
    >
        <div v-if="showing" :class="{'white-overlay': overlay}">
            <div class="loader-wrapper">
                <div class="pulled-left" style="padding: 10px 20px">{{label}}</div>

                <div class="wrapper-spinner">
                    <div class="cssload-container">
                    	<div class="cssload-whirlpool"></div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: {
            label: {
                default: 'Loading...'
            },
            show: {
                default: false
            },
            overlay: {
                default: true
            },
            // central event bus
            eventBus: {
                default: null
            },
            eventShow: {
                default: 'show-full-loading'
            },
            eventHide: {
                default: 'hide-full-loading'
            }
        },
        data() {
            return {
                showing: false
            }
        },
        watch: {
            show(val){
                this.showing = val;
            }
        },
        methods: {
            showMe() {
                this.showing = true
            },
            hideMe() {
                this.showing = false
            },
            // Register eventBus methods.
            registerBusMethods()
            {
                this.eventBus.$on(this.eventShow, this.showMe);
                this.eventBus.$on(this.eventHide, this.hideMe);
            }
        },
        mounted() {
            // If event bus, register methods.
            if (this.eventBus)
                this.registerBusMethods();

        }
    }
</script>
<style scoped>
    /*--- Contenedor Principal ---*/
    .white-overlay {
        background-color: rgba(255, 255, 255, 0.75);
        z-index: 9999;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100vw;
        position: fixed;
        margin: 0;
    }
    /*-- Contendor de TEXTO y ANIMACION ---*/
    .loader-wrapper {
        position: absolute;
        display: inline-block;
        right: 10vw;
        bottom: 10vh;
    }

    .pulled-left {
        float: left;
    }
    /*--- Contenedor de Box de Spinner -----*/
    .wrapper-spinner {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 40px;
        font-size: 0;
    }
    .cssload-container{
    	position:relative;
    }

    .cssload-whirlpool,
    .cssload-whirlpool::before,
    .cssload-whirlpool::after {
    	position: absolute;
    	top: 50%;
    	left: 50%;
    	border: 1px solid rgb(204,204,204);
    	border-left-color: rgb(0,0,0);
    	border-radius: 974px;
    		-o-border-radius: 974px;
    		-ms-border-radius: 974px;
    		-webkit-border-radius: 974px;
    		-moz-border-radius: 974px;
    }

    .cssload-whirlpool {
    	margin: -24px 0 0 -24px;
    	height: 49px;
    	width: 49px;
    	animation: cssload-rotate 1150ms linear infinite;
    		-o-animation: cssload-rotate 1150ms linear infinite;
    		-ms-animation: cssload-rotate 1150ms linear infinite;
    		-webkit-animation: cssload-rotate 1150ms linear infinite;
    		-moz-animation: cssload-rotate 1150ms linear infinite;
    }

    .cssload-whirlpool::before {
    	content: "";
    	margin: -22px 0 0 -22px;
    	height: 43px;
    	width: 43px;
    	animation: cssload-rotate 1150ms linear infinite;
    		-o-animation: cssload-rotate 1150ms linear infinite;
    		-ms-animation: cssload-rotate 1150ms linear infinite;
    		-webkit-animation: cssload-rotate 1150ms linear infinite;
    		-moz-animation: cssload-rotate 1150ms linear infinite;
    }

    .cssload-whirlpool::after {
    	content: "";
    	margin: -28px 0 0 -28px;
    	height: 55px;
    	width: 55px;
    	animation: cssload-rotate 2300ms linear infinite;
    		-o-animation: cssload-rotate 2300ms linear infinite;
    		-ms-animation: cssload-rotate 2300ms linear infinite;
    		-webkit-animation: cssload-rotate 2300ms linear infinite;
    		-moz-animation: cssload-rotate 2300ms linear infinite;
    }

    @keyframes cssload-rotate {
    	100% {
    		transform: rotate(360deg);
    	}
    }

    @-o-keyframes cssload-rotate {
    	100% {
    		-o-transform: rotate(360deg);
    	}
    }

    @-ms-keyframes cssload-rotate {
    	100% {
    		-ms-transform: rotate(360deg);
    	}
    }

    @-webkit-keyframes cssload-rotate {
    	100% {
    		-webkit-transform: rotate(360deg);
    	}
    }

    @-moz-keyframes cssload-rotate {
    	100% {
    		-moz-transform: rotate(360deg);
    	}
    }

</style>
