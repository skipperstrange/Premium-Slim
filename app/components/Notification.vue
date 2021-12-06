<template>
      <v-alert
      color="red lighten-2"
      transition="scale-transition"
      dismissible
      dark
    >
       {{ message }}
    </v-alert>
</template>

<script>
export default {
  name: 'Notification',
  props: ['message']
}
</script>