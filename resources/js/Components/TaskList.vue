<template>
  <div class="container mx-auto">
    <input
      v-model="searchQuery"
      type="text"
      class="mr-2 w-64 px-4 py-2 mb-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
    />

    <select
      v-model="selectedTag"
      class="mr-2 w-64 px-4 py-2 mb-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
      placeholder="Buscar tarea..."
    >
      <option v-for="tag in tags" :key="tag.id" :value="tag.id">
        {{ tag.name }}
      </option>
    </select>

    <div class="overflow-x-auto">

    <table class="min-w-full max-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Tarea
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
            Etiquetas
          </th>
          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Fecha Programada
          </th>
          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Estado
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
            <div class="text-sm text-gray-900">
              <ul class="inline-flex space-x-2">
                <li
                  v-for="tag in task.tags"
                  :key="tag.id"
                  class="px-3 py-2 text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                >
                  {{ tag.name }}
                </li>
              </ul>
            </div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ task.venciment }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ task.status }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex flex-wrap">
            <button
              class="mr-2 px-2 py-1 text-sm font-medium text-white bg-blue-500 rounded-md shadow-sm hover:bg-blue-600"
              @click="showTask(task.id)"
            >
              Ver
            </button>
            <button v-if="task.status !== 'Completada'"
              class="mr-2 px-2 py-1 text-sm font-medium text-white bg-blue-500 rounded-md shadow-sm hover:bg-blue-600"
              @click="confirmCompletedTask(task.id)"
            >
              Completar
            </button>
            <button v-if="task.status !== 'Completada'"
              class="mr-2 px-2 py-1 text-sm font-medium text-white bg-blue-500 rounded-md shadow-sm hover:bg-blue-600"
              @click="editTask(task.id)"
            >
              Editar
            </button>
            <button
              class="mr-2 px-2 py-1 text-sm font-medium text-white bg-red-500 rounded-md shadow-sm hover:bg-red-600"
              @click="confirmDeleteTask(task.id)"
            >
              Eliminar
            </button>
          </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
    <div class="mt-4">
      <Pagination
        :total="totalTasks"
        :page="currentPage"
        @paginate="fetchTasks"
      />
    </div>
  </div>
</template>
    
    <script>
import { ref, reactive, watch } from "vue";
import Pagination from "@/components/Pagination.vue";
import { router } from "@inertiajs/vue3";

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
      allTasks: [],
      tags: [],
    };
  },
  computed: {

    filteredTasks() {
    const { searchQuery, allTasks, tasks, selectedTag } = this;
    let filteredTasks = tasks;

    if (searchQuery) {
      const query = searchQuery.toLowerCase();
      filteredTasks = filteredTasks.filter(
        (task) =>
          task.title.toLowerCase().includes(query) ||
          task.description.toLowerCase().includes(query)
      );
    }

    if (selectedTag) {
      filteredTasks = filteredTasks.filter((task) =>
        task.tags.some((tag) => tag.id === selectedTag)
      );
    }

    return filteredTasks;
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
          this.allTasks = await this.fetchAllTasks();
          this.tags = await this.fetchTags();
        } else {

        }
      } catch (error) {

      }
    },

    async fetchAllTasks() {
      try {
        const response = await fetch(`/task-list?page=all`);
        if (response.ok) {
          const data = await response.json();
          return data.tasks;
        } else {
          console.error("Error al obtener todas las tareas desde el backend");
        }
      } catch (error) {
        console.error("Error en la solicitud HTTP:", error);
      }
      return []; // En caso de error, devolver un array vacío
    },

    async fetchTags() {
      try {
        const response = await fetch("/tag-list");
        if (response.ok) {
          const data = await response.json();
          console.log(data.tags)
          return data.tags;
        } else {
          console.error("Error al obtener las etiquetas desde el backend");
        }
      } catch (error) {
        console.error("Error en la solicitud HTTP:", error);
      }
      return []; 
    },

    editTask(taskId) {
      router.get(route("tasks.edit", taskId));
    },
    deleteTask(taskId) {
      router.delete(route("tasks.destroy", taskId));
    },
    showTask(taskId) {
      router.get(route("tasks.show", taskId));
    },
    completedTask(taskId) {
      router.put(route("tasks.update", taskId));
    },
    confirmDeleteTask(taskId) {
      if (window.confirm("¿Estás seguro de eliminar esta tarea?")) {
        this.deleteTask(taskId);
      }
    },
    confirmCompletedTask(taskId) {
      if (window.confirm("¿Estás seguro que quieres marcar esta tarea como completada?")) {
        this.completedTask(taskId);
      }
    },
  },
  watch: {
    currentPage: {
      immediate: true,
      handler(newPage) {
        this.fetchTasks(newPage);
      },
    },
  },
};
</script>
    