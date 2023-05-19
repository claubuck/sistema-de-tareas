<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import List from "@/Components/TaskList.vue"

</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Mis tareas
        </h2>
        <a
          class="inline-block rounded border border-indigo-600 bg-indigo-600 px-12 py-3 text-sm font-medium text-white hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500"
          :href="route('tasks.create')"
        >
          Nueva tarea
        </a>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">Listado de tareas</div>
          <div class="header flex justify-between border-b p-2">
        
            <List/>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
