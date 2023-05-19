<template>
  <AuthenticatedLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div>
              <FullCalendar :options="calendarOptions" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
  
  <script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, onMounted } from "vue";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import { router } from "@inertiajs/vue3";

export default {
  components: {
    FullCalendar,
    AuthenticatedLayout,
  },
  setup() {
    const calendarOptions = ref({
      plugins: [dayGridPlugin],
      initialView: "dayGridMonth",
      events: [], // Aquí se agregarán los eventos de las tareas
      eventClick: handleEventClick, // Manejar el evento de clic en un evento del calendario
    });

    onMounted(() => {
      // Obtén las tareas del backend y agrega los eventos al calendario
      fetchTasks().then((tasks) => {
        const events = tasks.map((task) => ({
          title: task.title,
          start: task.venciment,
          id: task.id,
          // Otras propiedades de los eventos según tus necesidades
        }));
        calendarOptions.value.events = events;
      });
    });

    function handleEventClick(info) {
      const taskId = info.event.id;

      router.get(route("tasks.show", taskId));
    }

    return {
      calendarOptions,
    };
  },
};

async function fetchTasks() {
  const response = await fetch("/task-calendar");
  const data = await response.json();
  return data.tasks;
}
</script>
  