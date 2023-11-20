<template>
    <PanelItem :index="index" :field="field">
        <template #value>
            <span
                v-if="field.value.length > 0"
                v-html="field.value.map((value) => value[field.listBy]).join('<br/>')"
            />
            <span v-else>&mdash;</span>
        </template>
    </PanelItem>
</template>

<script>
export default {
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
}
</script>
