<template>
  <div class="container text-start">
    <h1 class="text-primary fw-bold">Nuevo Producto</h1> <!-- Solo título azul -->
    <div class="card">
      <div class="card-header fw-bold">Datos del Producto</div>
      <div class="card-body">
        <form @submit.prevent="saveProduct">
          <!-- Nombre -->
          <div class="row mb-3">
            <label for="name" class="form-label">Nombre del producto:</label> <!-- Label sin cambio -->
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="box" />
              </div>
              <input
                type="text"
                class="form-control"
                id="name"
                v-model="product.name"
                placeholder="Nombre"
                required
                @input="clearNameError"
              />
            </div>
            <div v-if="errorsBackend.name" class="text-danger mt-1">
              {{ errorsBackend.name[0] }}
            </div>
          </div>

          <!-- Precio -->
          <div class="row mb-3">
            <label for="precio" class="form-label">Precio:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="dollar-sign" />
              </div>
              <input
                type="number"
                class="form-control"
                id="precio"
                v-model.number="product.precio"
                placeholder="Precio"
                min="0"
                required
              />
            </div>
          </div>

          <!-- Stock -->
          <div class="row mb-3">
            <label for="stock" class="form-label">Stock:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="boxes" />
              </div>
              <input
                type="number"
                class="form-control"
                id="stock"
                v-model.number="product.stock"
                placeholder="Stock disponible"
                min="0"
                required
              />
            </div>
          </div>

          <!-- Categoría -->
          <div class="row mb-3">
            <label for="category_id" class="form-label">Categoría:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="tags" />
              </div>
              <select
                class="form-select"
                id="category_id"
                v-model="product.category_id"
                required
              >
                <option disabled value="">Seleccione una categoría</option>
                <option
                  v-for="category in categories"
                  :key="category.id"
                  :value="category.id"
                >
                  {{ category.name }}
                </option>
              </select>
            </div>
          </div>

          <!-- Botones -->
          <button type="submit" class="btn btn-primary">Guardar</button> <!-- Botón azul -->
          <button type="button" class="btn btn-secondary mx-2" @click="cancel">
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
  name: "NewProducts",
  data() {
    return {
      product: {
        name: "",
        precio: 0,
        stock: 0,
        category_id: "",
      },
      categories: [],
      errorsBackend: {}, // errores recibidos del backend
    };
  },
  mounted() {
    this.fetchCategories();
  },
  methods: {
    async fetchCategories() {
      try {
        const res = await axios.get("http://127.0.0.1:8000/api/categories");
        this.categories = res.data.categories;
      } catch (error) {
        console.error("Error al obtener categorías:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "No se pudieron cargar las categorías.",
        });
      }
    },
    cancel() {
      this.$router.push({ name: "Products" });
    },
    clearNameError() {
      if (this.errorsBackend.name) {
        this.errorsBackend.name = null;
      }
    },
    async saveProduct() {
      try {
        const payload = {
          ...this.product,
          category_id: parseInt(this.product.category_id),
        };
        console.log("Payload enviado:", payload);

        const res = await axios.post(
          "http://127.0.0.1:8000/api/products",
          payload
        );
        console.log("Respuesta backend:", res.data);

        if (res.status === 200 || res.status === 201) {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Producto creado correctamente",
            showConfirmButton: false,
            timer: 2000,
          });
          this.$router.push({ name: "Products" });
        }
      } catch (error) {
        console.error("Error al crear producto:", error);
        console.log("Detalle del error:", error.response?.data);

        // Guardar errores específicos para mostrarlos en el formulario
        this.errorsBackend = error.response?.data?.errors || {};

        let msg = "No se pudo crear el producto.";

        if (this.errorsBackend && Object.keys(this.errorsBackend).length > 0) {
          msg = Object.values(this.errorsBackend).flat().join("\n");
        } else if (error.response?.data?.msg) {
          msg = error.response.data.msg;
        }

        Swal.fire({
          icon: "error",
          title: "Error",
          text: msg,
        });
      }
    },
  },
};
</script>
