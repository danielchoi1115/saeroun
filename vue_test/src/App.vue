<template>
  <h1>{{ title }}</h1>
  <input type="text" ref="name" />

  <teleport to=".modals" v-if="showModal">
    <Test @close="toggleModal">
      <template v-slot:links>
        <a href="#">Sign up now</a>
        <a href="#">More info</a>
      </template>
    </Test>
  </teleport>

  <teleport to=".modals" v-if="showModalTwo">
    <Test @close="toggleModalTwo">
      <h1>Sign Up to the newsletter</h1>
    </Test>
  </teleport>
  
  <button @click="handleClick">Click me</button>
  <button @click="toggleModal">Show Modal</button>
  <button @click="toggleModalTwo">Show ModalTwo</button>

</template>

<script>
import Test from './components/Test.vue';

export default {
  name: "App", 
  components: { Test },
  
  data() {
    return {
      title: "My First Vue App",
      showModal: false,
      showModalTwo: false
    };
  },
  methods: {
    handleClick() {
      console.log(this.$refs.name);
      this.$refs.name.classList.add("active");
      this.$refs.name.focus();
    },
    toggleModal() {
      this.showModal = !this.showModal
    },
    toggleModalTwo() {
      this.showModalTwo = !this.showModalTwo
    },
  },
  
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}

h1 {
  border-bottom: 1px solid #ddd;
  display: inline-block;
  padding-bottom: 10px;
}
</style>
