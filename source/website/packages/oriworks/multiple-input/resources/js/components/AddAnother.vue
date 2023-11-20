<template>
  <DefaultButton
    @click="$emit('click')"
    type="button"
    class="rounded dim font-bold text-sm text-primary inline-flex items-center focus:outline-none active:outline-none focus:shadow-outline active:shadow-outline pl-1 pr-2"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2">
        <path strokeLinecap="round" strokeLinejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
    </svg>
    <span>{{ __("Add Another") }}</span>
  </DefaultButton>
</template>

<script>
export default {
  //
};
</script>
