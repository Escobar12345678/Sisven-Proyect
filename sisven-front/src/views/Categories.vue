<template>
  <div class="container">
    <h1>Listado de Categorías</h1>
    <button @click="newCategory()" class="btn btn-success mx-2">
      <font-awesome-icon icon="plus" /> Nueva Categoría
    </button>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre</th>
          <th scope="col">Descripción</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(category, index) in categories" :key="category.id">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ category.name }}</td>
          <td>{{ category.description }}</td>
          <td>
            <button
              @click="deleteCategory(category.id)"
              class="btn btn-danger mx-2"
            >
              <font-awesome-icon icon="trash" />
            </button>
            <button
              @click="editCategory(category.id)"
              class="btn btn-warning mx-2"
            >
              <font-awesome-icon icon="pencil" />
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
  name: "CategoriesList",
  data() {
    return {
      categories: [],
    };
  },
  methods: {
    fetchCategories() {
      axios
        .get("http://127.0.0.1:8000/api/categories")
        .then((response) => {
          this.categories = response.data.categories;
        })
        .catch((error) => {
          console.error("Error al obtener categorías:", error);
        });
    },
    deleteCategory(id) {
      Swal.fire({
        title: `¿Deseas eliminar la categoría con ID ${id}?`,
        showCancelButton: true,
        confirmButtonText: "Eliminar",
        icon: "warning",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .delete(`http://127.0.0.1:8000/api/categories/${id}`)
            .then((response) => {
              Swal.fire("¡Eliminada!", "La categoría fue eliminada correctamente.", "success");
              this.fetchCategories();
            })
            .catch((error) => {
              console.error("Error eliminando categoría:", error);
              Swal.fire("Error", "No se pudo eliminar la categoría.", "error");
            });
        }
      });
    },
    editCategory(id) {
      this.$router.push({ name: "EditCategories", params: { id: `${id}` } });
    },
    newCategory() {
      this.$router.push({ name: "NewCategories" });
    },
  },
  mounted() {
    this.fetchCategories();
  },
};
</script>
