<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { router } from '@inertiajs/vue3';
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
  methods: {
    editTask() {
        router.get(route('tasks.edit', this.task.id));
    },
    deleteTask() {
        router.delete(route('tasks.destroy', this.task.id));
    },
    confirmDeleteTask() {
      if (window.confirm('¿Estás seguro de eliminar esta tarea?')) {
        this.deleteTask();
      }
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
            <h1 class="text-2xl font-bold">Detalle de tarea</h1>
            <div class="container mx-auto">
              <h5 class="text-2xl font-bold mb-4">Tarea: {{ task.title }}</h5>
              <p class="mb-2">Descripcion: {{ task.description }}</p>
              <p class="mb-2">Estado: {{ task.status }}</p>

              <div class="flex mt-4">
                <button
                  class="mr-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                  @click="editTask"
                >
                  Editar
                </button>
                <button
                  class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                  @click="confirmDeleteTask"
                >
                  Eliminar
                </button>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
  
 