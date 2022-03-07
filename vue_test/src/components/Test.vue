<template>
  <div class="backdrop" @click.self="closeModal">
    <div class="modal">
      <slot>default</slot>
      <div class="action">
        <slot name="links"></slot>
      </div>
    </div>
  </div>
</template>

<script>

export default{
  props: [],

  methods: {
    closeModal() {
      this.$emit('close')
    }
  }
}
</script>


<style scoped>
  .modal {
    width: 400px;
    padding: 20px;
    margin: 100px auto;
    background: white;
    border-radius: 10px;
  }
  .backdrop {
    top: 0;
    position: fixed;
    background: rgba(0, 0, 0, 0.5);
    width: 100%;
    height: 100%;
  }
  h1 {
    color: #03cfb4;
    border: none;
    padding: 0;
  }
</style>
