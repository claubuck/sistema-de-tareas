<template>
  <nav>
    <ul class="pagination">
      <li :class="{ disabled: currentPage === 1 }">
        <a @click="goToPage(1)" class="pagination-link" aria-label="Ir a la primera página">
          <span class="icon">&laquo;</span>
        </a>
      </li>
      <li :class="{ disabled: currentPage === 1 }">
        <a @click="previousPage" class="pagination-link" aria-label="Página anterior">
          <span class="icon">&lsaquo;</span>
        </a>
      </li>
      <li v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
        <a @click="goToPage(page)" class="pagination-link">{{ page }}</a>
      </li>
      <li :class="{ disabled: currentPage === totalPages }">
        <a @click="nextPage" class="pagination-link" aria-label="Página siguiente">
          <span class="icon">&rsaquo;</span>
        </a>
      </li>
      <li :class="{ disabled: currentPage === totalPages }">
        <a @click="goToPage(totalPages)" class="pagination-link" aria-label="Ir a la última página">
          <span class="icon">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
import { defineEmits, watch } from 'vue';

export default {
  props: {
    total: {
      type: Number,
      required: true,
    },
    page: {
      type: Number,
      required: true,
    },
    pageSize: {
      type: Number,
      default: 10,
    },
  },
  emits: ['paginate'],
  computed: {
    totalPages() {
      return Math.ceil(this.total / this.pageSize);
    },
  },
  watch: {
    total() {
      this.checkPageValidity();
    },
  },
  methods: {
    goToPage(page) {
      if (page !== this.page) {
        this.$emit('paginate', page);
      }
    },
    previousPage() {
      if (this.page > 1) {
        this.goToPage(this.page - 1);
      }
    },
    nextPage() {
      if (this.page < this.totalPages) {
        this.goToPage(this.page + 1);
      }
    },
    checkPageValidity() {
      if (this.page > this.totalPages) {
        this.goToPage(1);
      }
    },
  },
};
</script>

<style scoped>
.pagination {
  display: flex;
  list-style: none;
  padding: 0;
}

.pagination li {
  margin-right: 0.5rem;
}

.pagination-link {
  display: inline-block;
  padding: 0.25rem 0.5rem;
  text-decoration: none;
  color: #333;
  border: 1px solid #ccc;
  border-radius: 0.25rem;
}

.pagination-link:hover,
.pagination-link:focus {
  background-color: #eee;
}

.pagination-link.active {
  background-color: #333;
  color: #fff;
}
</style>
