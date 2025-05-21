<template>
  <div class="container text-start">
    <h1 class="text-primary fw-bold">Editar Producto</h1> 
    <div class="card">
      <div class="card-header fw-bold">Datos del Producto</div>
      <div class="card-body">
        <form @submit.prevent="updateProduct">

          <!-- Nombre -->
          <div class="row mb-3">
            <label for="name" class="form-label">Nombre del producto:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="box" />
              </div>
              <input
                type="text"
                id="name"
                class="form-control"
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
                id="precio"
                class="form-control"
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
                id="stock"
                class="form-control"
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
                id="category_id"
                class="form-select"
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
  name: "EditProducts",
  data() {
    return {
      product: {
        id: null,
        name: "",
        precio: 0,
        stock: 0,
        category_id: "",
      },
      categories: [],
      errorsBackend: {}, // errores recibidos del backend
    };
  },
  methods: {
    cancel() {
      this.$router.push({ name: "Products" });
    },
    clearNameError() {
      if (this.errorsBackend.name) {
        this.errorsBackend.name = null;
      }
    },
    async updateProduct() {
      try {
        const payload = {
          name: this.product.name,
          precio: this.product.precio,
          stock: this.product.stock,
          category_id: parseInt(this.product.category_id),
        };

        const res = await axios.put(
          `http://127.0.0.1:8000/api/products/${this.product.id}`,
          payload
        );

        if (res.status === 200) {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Producto actualizado correctamente",
            showConfirmButton: false,
            timer: 2000,
          });
          this.$router.push({ name: "Products" });
        }
      } catch (error) {
        console.error("Error al actualizar producto:", error);
        this.errorsBackend = error.response?.data?.errors || {};

        let msg = "No se pudo actualizar el producto.";

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
    async fetchCategories() {
      try {
        const res = await axios.get("http://127.0.0.1:8000/api/categories");
        this.categories = res.data.categories;
      } catch (error) {
        console.error("Error al cargar categorías:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "No se pudieron cargar las categorías.",
        });
      }
    },
    async fetchProduct() {
      const id = this.$route.params.id;
      try {
        const res = await axios.get(`http://127.0.0.1:8000/api/products/${id}`);
        this.product = res.data.product;
      } catch (error) {
        console.error("Error al obtener el producto:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "No se pudo cargar la información del producto.",
        });
      }
    },
  },
  mounted() {
    this.fetchCategories();
    this.fetchProduct();
  },
};
</script>
