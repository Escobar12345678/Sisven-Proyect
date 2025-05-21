<template>
  <div class="container text-start">
    <h1 class="text-primary fw-bold">Editar Categoría</h1>
    <div class="card">
      <div class="card-header fw-bold">Datos de la Categoría</div>
      <div class="card-body">
        <form @submit.prevent="updateCategory">
          <div class="row mb-3">
            <label for="name" class="form-label">Nombre de la Categoría:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="tag" />
              </div>
              <input
                type="text"
                class="form-control"
                id="name"
                v-model="category.name"
              />
            </div>
          </div>

          <div class="row mb-3">
            <label for="description" class="form-label">Descripción:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="align-left" />
              </div>
              <textarea
                class="form-control"
                id="description"
                v-model="category.description"
                rows="3"
              ></textarea>
            </div>
          </div>

          <button type="submit" class="btn btn-primary me-2">Guardar</button>
          <button type="button" class="btn btn-secondary" @click="cancel">
            Cancelar
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
  name: "EditCategory",
  data() {
    return {
      category: {
        id: null,
        name: "",
        description: "",
      },
    };
  },
  methods: {
    cancel() {
      this.$router.push({ name: "Categories" });
    },
    async updateCategory() {
      try {
        const res = await axios.put(
          `http://127.0.0.1:8000/api/categories/${this.category.id}`,
          this.category
        );
        if (res.status === 200) {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Categoría actualizada correctamente",
            showConfirmButton: false,
            timer: 2000,
          });
          this.$router.push({ name: "Categories" });
        }
      } catch (error) {
        console.error("Error al actualizar categoría:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "No se pudo actualizar la categoría.",
        });
      }
    },
  },
  mounted() {
    const id = this.$route.params.id;
    axios
      .get(`http://127.0.0.1:8000/api/categories/${id}`)
      .then((response) => {
        this.category = response.data.category;
      })
      .catch((error) => {
        console.error("Error al obtener la categoría:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "No se pudo cargar la información de la categoría.",
        });
      });
  },
};
</script>
