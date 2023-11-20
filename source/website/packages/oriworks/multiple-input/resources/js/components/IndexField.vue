<template>
  <span v-if="field.value.length === 0">&mdash;</span>
  <span v-else-if="field.value.length === 1">{{
    field.value.map((value) => value[field.listBy]).join(";")
  }}</span>
  <span v-else>{{ `${field.value.length} ${field.attribute}` }}</span>
</template>

<script>
export default {
  props: ["resourceName", "field"],
};
</script>
