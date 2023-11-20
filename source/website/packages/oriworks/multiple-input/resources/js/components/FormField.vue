<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
    <template #field>
      <div
        v-for="(_, index) in values"
        :key="`${field.listBy}-${index}`"
        class="flex mb-3"
      >
        <input
          :id="field.name"
          type="text"
          class="w-full form-control form-input form-input-bordered"
          :class="errorClasses"
          :placeholder="field.name"
          v-model="values[index]"
        />
        <DefaultButton
            type="button"
            @click="removeValue(index)"
            class="rounded bg-40 hover:bg-danger px-3 ml-2 cursor-pointer text-danger hover:text-white"
        >
            <Icon type="trash" :solid="false" />
        </DefaultButton >
      </div>
      <add-another
        v-if="canAddAnother"
        @click="addNewValue"
        class="ml-1 no-shrink"
        :dusk="`${field.attribute}-inline-create`"
      />
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";
import AddAnother from "./AddAnother.vue";

export default {
  components: { AddAnother },
  mixins: [FormField, HandlesValidationErrors],

  data: () => ({
    value: "",
    values: [""],
  }),

  props: ["resourceName", "resourceId", "field"],

  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.values = this.field.value.length
        ? this.field.value.map((value) => value[this.field.listBy])
        : [""];
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      this.values
        .map((s) => s.trim())
        .filter((x) => x != "")
        .forEach((v, i) => {
          formData.append(`${this.field.attribute}[${i}]`, v);
        });
    },

    canAddAnother() {
      return true;
    },

    addNewValue(e) {
        e.preventDefault();
      this.values.push("");
    },

    removeValue(index) {
      this.values.splice(index, 1);
    },
  },
};
</script>
