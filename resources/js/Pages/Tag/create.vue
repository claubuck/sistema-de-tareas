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
        name: "",
      },
    };
  },
  methods: {
    submitForm() {
      this.$inertia.post(route("tags.store"), this.form);
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
            <h1 class="text-2xl font-bold">Crear etiqueta</h1>

            <form @submit.prevent="submitForm">
              <div class="my-4">
                <label for="name" class="block font-semibold">Nombre:</label>
                <input
                  type="text"
                  id="name"
                  v-model="form.name"
                  class="w-full px-4 py-2 border border-gray-300 rounded"
                />
                <!-- <div v-if="$page.errors.name" class="text-red-500">
                  {{ $page.errors.name[0] }}
                </div> -->
              </div>

              <button
                type="submit"
                class="px-4 py-2 bg-blue-500 text-white rounded"
              >
                Guardar
              </button>
              <button class="px-4 py-2 bg-red-500 text-white rounded">
                <a :href="route('tasks.create')"> Cancelar </a>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
  
 