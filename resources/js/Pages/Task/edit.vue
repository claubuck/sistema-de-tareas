<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
export default {
    components: {
    AuthenticatedLayout,
    Head,
  },
  props: {
    task: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      form: {
        title: "",
        description: "",
        venciment: "",
      },
    };
  },
  mounted() {
    this.loadTask();
  },
  methods: {
    loadTask() {
      // Asignar los valores de la tarea a los campos del formulario
      this.form.title = this.task.title;
      this.form.description = this.task.description;
      this.form.venciment = this.task.venciment;
    },
    submitForm() {
      // Enviar la solicitud de actualización de la tarea
      this.$inertia.put(route("tasks.update", { task: this.task.id }), this.form);
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
  
 