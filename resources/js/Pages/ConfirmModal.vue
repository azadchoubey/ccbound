<template>
    <div v-if="show" class="modal-overlay" @click="close">
      <div class="p-5 modal-container" @click.stop>
        <div class="modal-header">
          <slot name="header">
            <h4>Confirm</h4>
          </slot>
        </div>
        <div class="modal-body">
          <slot name="body">
            <p>Are you sure you want to delete this item?</p>
            <p>{{ message }}</p>
          </slot>
        </div>
        <div class="modal-footer">
          <slot name="footer">
            <PrimaryButton @click="confirm" class="bg-red-600 btn">Yes</PrimaryButton>
            <PrimaryButton @click="close"  class="ml-5 bg-blue-600 btn" >No</PrimaryButton>
          </slot>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import PrimaryButton from '../components/PrimaryButton.vue';
  export default {
    components: {
        PrimaryButton
    },
    props: {
      show: {
        type: Boolean,
        required: true
      },
      message: {
        type: String
      }
    },
    methods: {
      close() {
        this.$emit('close');
      },
      confirm() {
        this.$emit('confirm');
      }
    }
  }
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .modal-container {
    background: white;
    padding: 20px;
    border-radius: 5px;
  }
  .modal-header,
  .modal-body,
  .modal-footer {
    margin-bottom: 10px;
  }
  </style>
  