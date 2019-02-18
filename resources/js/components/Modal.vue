<template>
    <div class="modal fade in" id="modal-default" style="display:block;padding-right: 15px;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" v-on:click="close" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">
                    <slot name="header">
                        Default Modal
                    </slot>
                    </h4>
              </div>
              <div class="modal-body">
                <slot></slot>
              </div>
              <div class="modal-footer" v-if="this.save">
                    <button type="button" class="btn btn-default pull-left" v-on:click="close">Close</button>
                    
                    <button type="button" class="btn btn-primary" v-on:click="action" >
                        <slot name="action">
                            Save changes
                        </slot>
                    </button>
              </div>
            </div>
          </div>
        </div>
</template>
<script>
    export default {
        name: 'modal',
        props: ['save'],
        methods: {
            close() {
                this.$emit('close');
            },
            action(){
                this.$emit();
            }
        },
    }
</script>

