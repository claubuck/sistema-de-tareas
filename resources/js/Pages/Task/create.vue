<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import InputError from '@/Components/InputError.vue';
export default {
  components: {
    AuthenticatedLayout,
    Head,
    InputError,
  },

  props: {
    tagOptions: {
      type: Array,
      required: true,
    },
  },

  data() {
    return {
      form: {
        title: "",
        description: "",
        venciment: "",
        tags: [],
        errors: {},
      },
      tagInput: "",
      isTagDropdownVisible: false,

    };
  },


  methods: {

    submitForm() {
  return new Promise((resolve, reject) => {
    this.$inertia.post(route("tasks.store"), this.form, {
      preserveState: true,
      onSuccess: () => resolve(),
      onError: (error) => reject(error),
    });
  })
    .then(() => {
      this.form.errors = {};
    })
    .catch((error) => {
       
        this.form.errors = error;
    });
},



    handleTagInput() {
      this.isTagDropdownVisible = this.tagInput.length > 0;
    },

    addTag() {
      const tag = this.tagInput.trim();
      if (tag) {
        const selectedTag = this.tagOptions.find(
          (option) => option.name === tag
        );
        if (selectedTag && !this.form.tags.includes(selectedTag.id)) {
          this.form.tags.push(selectedTag.id);
        }
      }
      this.tagInput = "";
      this.isTagDropdownVisible = false;
    },

    removeTag(index) {
      this.form.tags.splice(index, 1);
    },

    selectTag(tag) {
      this.tagInput = tag.name;
      this.addTag();
    },

    getTagName(tagId) {
      const tag = this.tagOptions.find((option) => option.id === tagId);
      return tag ? tag.name : "";
    },
  },
};
</script>

<template>
  <AuthenticatedLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <h1 class="text-2xl font-bold">Crear tarea</h1>

            <form @submit.prevent="submitForm">
              <div class="my-4">
                <label for="title" class="block font-semibold">Título:</label>
                <input
                  type="text"
                  id="title"
                  v-model="form.title"
                  class="w-full px-4 py-2 border border-gray-300 rounded"
                />
                <InputError class="mt-2" :message="form.errors.title" />
              </div>

              <div class="my-4">
                <label for="description" class="block font-semibold"
                  >Descripción:</label
                >
                <textarea
                  id="description"
                  v-model="form.description"
                  class="w-full px-4 py-2 border border-gray-300 rounded"
                ></textarea>
                <InputError class="mt-2" :message="form.errors.description" />
              </div>

              <div class="my-4">
                <label for="deadline" class="block font-semibold"
                  >Fecha y hora de finalización:</label
                >
                <input
                  type="datetime-local"
                  id="venciment"
                  v-model="form.venciment"
                  class="w-full px-4 py-2 border border-gray-300 rounded"
                />
                <InputError class="mt-2" :message="form.errors.venciment" />
              </div>

              <div class="my-4">
                <label class="block font-semibold">Etiquetas:</label>
                <div class="flex">
                  <div class="relative">
                    <input
                      type="text"
                      v-model="tagInput"
                      @input="handleTagInput"
                      @keydown.enter.prevent="addTag"
                      class="w-full px-4 py-2 border border-gray-300 rounded"
                      placeholder="Escribe una etiqueta y presiona Enter"
                    />
                    <ul
                      class="absolute z-10 w-full bg-white shadow-md py-2 mt-1"
                      v-show="isTagDropdownVisible"
                    >
                      <li
                        v-for="tag in tagOptions"
                        :key="tag.id"
                        @click="selectTag(tag)"
                        class="px-4 py-2 cursor-pointer hover:bg-gray-100"
                      >
                        {{ tag.name }}
                      </li>
                    </ul>
                  </div>
                  <a
                    class="inline-block rounded border border-indigo-600 bg-indigo-600 px-12 py-3 text-sm font-medium text-white hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500"
                    :href="route('tags.create')"
                  >
                    Crear una nueva etiqueta
                  </a>
                </div>
                <ul class="mt-2">
                  <li
                    v-for="(tagId, index) in form.tags"
                    :key="index"
                    class="inline-block bg-blue-500 text-white rounded px-2 py-1 mr-2"
                  >
                    {{ getTagName(tagId) }}
                    <button class="ml-1" @click="removeTag(index)">x</button>
                  </li>
                </ul>
              </div>

              <button
                type="submit"
                class="px-4 py-2 bg-blue-500 text-white rounded"
              >
                Guardar
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
  
 