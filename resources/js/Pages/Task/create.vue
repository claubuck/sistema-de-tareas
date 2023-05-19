<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
export default {
  components: {
    AuthenticatedLayout,
    Head,
  },
  data() {
    return {
      form: {
        title: "",
        description: "",
        venciment: "",
        tags: [],
      },
      tagOptions: ["Tag 1", "Tag 2", "Tag 3"], // Opciones de etiquetas disponibles
      tagInput: "", // Valor del campo de entrada para etiquetas
      isTagDropdownVisible: false,
    };
  },
  methods: {
    submitForm() {
      this.$inertia.post(route("tasks.store"), this.form);
    },

    handleTagInput() {
      // Mostrar el menú desplegable de etiquetas si hay texto en el campo de entrada
      this.isTagDropdownVisible = this.tagInput.length > 0;
    },

    addTag() {
      const tag = this.tagInput.trim();
      if (tag && !this.form.tags.includes(tag)) {
        this.form.tags.push(tag);
      }
      this.tagInput = "";
      this.isTagDropdownVisible = false;
    },

    removeTag(index) {
      this.form.tags.splice(index, 1);
    },

    selectTag(tag) {
      this.tagInput = tag;
      this.addTag();
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
              </div>

              <!-- <div class="my-4">
                <label for="tag" class="block font-semibold"
                  >Etiquetas:</label
                >
                <select
                  id="countries"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                  <option selected>Agrega etiquetas a tu nueva tarea</option>
                  <option value="US">United States</option>
                  <option value="CA">Canada</option>
                  <option value="FR">France</option>
                  <option value="DE">Germany</option>
                </select>
              </div> -->

              <div class="my-4">
                <label class="block font-semibold">Etiquetas:</label>
                <div class="relative">
                  <input
                    type="text"
                    v-model="tagInput"
                    @input="handleTagInput"
                    @keydown.enter.prevent="addTag"
                    class="w-full px-4 py-2 border border-gray-300 rounded"
                    placeholder="Escribe una etiqueta y presiona Enter"
                  />
                  <ul class="absolute z-10 w-full bg-white shadow-md py-2 mt-1" v-show="isTagDropdownVisible">
                    <li v-for="tag in tagOptions" :key="tag" @click="selectTag(tag)" class="px-4 py-2 cursor-pointer hover:bg-gray-100">
                      {{ tag }}
                    </li>
                  </ul>
                </div>
                <ul class="mt-2">
                  <li v-for="(tag, index) in form.tags" :key="index" class="inline-block bg-blue-500 text-white rounded px-2 py-1 mr-2">
                    {{ tag }}
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
  
 