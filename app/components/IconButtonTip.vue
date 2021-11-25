<template>
  <v-tooltip bottom>
    <template #activator="{ on, attrs }" v-bind="attrs" v-on="on" @click="raiseClickEvent()">
      <v-btn>
        <v-icon icon class="m-0" :color="iconcolor"> 
          {{ icon }} 
        </v-icon>
      </v-btn>
    </template>
    <span> {{ tooltip }} </span>
  </v-tooltip>
</template>

<script>
  export default {
    name: "IconButtonTip",
    props: {
      icon: { type: String, required: false, default: "" },
      iconcolor: { type: String, required: false, default: "white" },
      tooltip: { type: String, required: false, default: "" },
      eventname: { type: String, required: false, default: "clickyclicky" },
    },
    methods: {
      raiseClickEvent() {
        this.$emit(this.eventname);
      },
    },
  };
</script>