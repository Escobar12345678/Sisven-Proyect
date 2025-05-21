<template>
  <div class="container">
    <h1>Listado de Productos</h1>
    <button @click="newProduct()" class="btn btn-success mx-2">
      <font-awesome-icon icon="plus" /> Nuevo Producto
    </button>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre</th>
          <th scope="col">Precio</th>
          <th scope="col">Stock</th>
          <th scope="col">ID Categoría</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(product, index) in products" :key="product.id">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ product.name }}</td>
          <td>{{ product.precio }}</td>
          <td>{{ product.stock }}</td>
          <td>{{ product.category_id }}</td>
          <td>
            <button
              @click="deleteProduct(product.id)"
              class="btn btn-danger mx-2"
            >
              <font-awesome-icon icon="trash" />
            </button>
            <button
              @click="editProduct(product.id)"
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
import Swal from 'sweetalert2'

export default {
  name: "ProductsList",
  data() {
    return {
      products: [],
    };
  },
  methods: {
    fetchProducts() {
      axios
        .get("http://127.0.0.1:8000/api/products")
        .then((response) => {
          this.products = response.data.products;
        })
        .catch((error) => {
          console.error("Error fetching products:", error);
        });
    },
    deleteProduct(id) {
      Swal.fire({
        title: `¿Deseas eliminar el producto con ID ${id}?`,
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        icon: 'warning',
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(`http://127.0.0.1:8000/api/products/${id}`)
            .then(response => {
              if (response.status === 200 || response.status === 204 || response.data.products) {
                Swal.fire('¡Eliminado!', 'El producto fue eliminado correctamente.', 'success');
                this.fetchProducts(); // Recarga los datos
              }
            })
            .catch(error => {
              console.error("Error eliminando producto:", error);
              Swal.fire('Error', 'No se pudo eliminar el producto.', 'error');
            });
        }
      });
    },
    editProduct(id) {
      this.$router.push({ name: 'EditProducts', params: { id: `${id}` } });
    },
    newProduct() {
      this.$router.push({ name: 'NewProducts' });
    }
  },
  mounted() {
    this.fetchProducts(); // Llamada inicial al cargar el componente
  }
};
</script>
