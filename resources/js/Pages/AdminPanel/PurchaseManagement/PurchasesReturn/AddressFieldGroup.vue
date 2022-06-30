// CustomInput.vue
  <template>
    <label>
      <div>{{label}}</div>
      <input
        v-bind="$attrs"
        type="text"
        v-on="$listeners"
        :value="value"
        @input="$emit('update', $event.target.value)">
    </label>
  </template>

  <script>
  export default {
    inheritAttrs: false,
    props: ["value", "label"],
    model: {
      prop: "value",
      event: "update"
    }
  };
  </script>

// App.vue
  <CustomInput
    placeholder="Your Name"
    @keydown.enter="search"
    v-model="name"
    label="Name"
  />

// CustomInput.vue
