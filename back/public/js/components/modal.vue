<template>
  <div id="modal" class="modal">
    <div class="modal-container" style="height:480px; width:460px;">
        <div class="header">
            <div class="title">{{ title }}</div>
        </div>
        <slot name="content"></slot>
    </div>

    <div class="overlay" @dblclick="close" @click="checkNotice"></div>
    <div v-if="closeNotice" style="top: 95%; position: fixed; color: white;">Кликните еще раз</div>
</div>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
                closeNotice: false
            }
        },
        props: ['show', 'title'],
        methods: {
            checkNotice() {
                if (this.closeNotice) {
                    this.close()
                } else {
                    this.closeNotice = true
                }
            },
            close() {
                this.closeNotice = false;
                document.body.style.overflow='';
                this.$store.commit('showAuthModal', false)
            },
        },
        mounted() {
            document.body.style.overflow='hidden';
        }
    }
</script>