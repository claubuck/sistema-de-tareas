<template>
  <div class="container mx-auto">
    <input
      v-model="searchQuery"
      type="text"
      class="w-64 px-4 py-2 mb-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
      placeholder="Buscar tarea..."
    />

    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Título
          </th>
          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Descripción
          </th>
          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Vencimiento
          </th>
          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Acciones
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="task in filteredTasks" :key="task.id">
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ task.title }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ task.description }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ task.venciment }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <button
              class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md shadow-sm hover:bg-blue-600"
              @click="editTask(task.id)"
            >
              Editar
            </button>
            <button
              class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-md shadow-sm hover:bg-red-600"
              @click="deleteTask(task.id)"
            >
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="mt-4">
        <Pagination :total="totalTasks" :page="currentPage" @paginate="fetchTasks" />
    </div>
  </div>
</template>
  
  <script>
import { ref, reactive, watch } from "vue";
import Pagination from "@/components/Pagination.vue";

export default {
  components: {
    Pagination,
  },
  data() {
    return {
      tasks: [],
      searchQuery: "",
      currentPage: 1,
      pageSize: 10,
      totalTasks: 0,
    };
  },
  computed: {
    filteredTasks() {
      const { searchQuery, tasks } = this;
      if (!searchQuery) {
        return tasks;
      }
      const query = searchQuery.toLowerCase();
      return tasks.filter(
        (task) =>
          task.title.toLowerCase().includes(query) ||
          task.description.toLowerCase().includes(query)
      );
    },
  },
  methods: {
    async fetchTasks(page) {
      try {
        const response = await fetch(
          `/task-list?page=${page}&pageSize=${this.pageSize}`
        );
        if (response.ok) {
          const data = await response.json();
          this.tasks = data.tasks;
          this.totalTasks = data.totalTasks;
        } else {
          // Manejo de error en caso de una respuesta no exitosa
          console.error("Error al obtener las tareas desde el backend");
        }
      } catch (error) {
        // Manejo de error en caso de una excepción
        console.error("Error en la solicitud HTTP:", error);
      }
    },
    editTask(taskId) {
      // Lógica para redirigir a la página de edición de la tarea con el ID proporcionado
      // Ejemplo:
      // this.$router.push({ name: 'edit-task', params: { taskId } });
      console.log(`Editar tarea con ID ${taskId}`);
    },
    deleteTask(taskId) {
      // Lógica para eliminar la tarea con el ID proporcionado
      // Ejemplo:
      // this.$confirm('¿Estás seguro de eliminar esta tarea?', 'Eliminar tarea', { type: 'warning' })
      //   .then(() => {
      //     // Lógica para eliminar la tarea
      //     console.log(`Eliminar tarea con ID ${taskId}`);
      //   })
      //   .catch(() => {
      //     // Cancelar eliminación
      //   });
      console.log(`Eliminar tarea con ID ${taskId}`);
    },
  },
  watch: {
    currentPage: {
      immediate: true,
      handler(newPage) {
        this.currentPage = newPage;
        this.fetchTasks(newPage);
      },
    },
  },
};
</script>
  