<template>
  <div class="container">
    <h1>Listado de Modos de Pago</h1>
    <button @click="newPayMode()" class="btn btn-success mx-2">
      <font-awesome-icon icon="plus" /> Nuevo Modo de Pago
    </button>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre</th>
          <th scope="col">Observación</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(payMode, index) in payModes" :key="payMode.id">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ payMode.name }}</td>
          <td>{{ payMode.observation }}</td>
          <td>
            <button
              @click="deletePayMode(payMode.id)"
              class="btn btn-danger mx-2"
            >
              <font-awesome-icon icon="trash" />
            </button>
            <button
              @click="editPayMode(payMode.id)"
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
  name: "PayModesList",
  data() {
    return {
      payModes: [],
    };
  },
  methods: {
    fetchPayModes() {
      axios
        .get("http://127.0.0.1:8000/api/pay_modes")
        .then((response) => {
          this.payModes = response.data.pay_modes;
        })
        .catch((error) => {
          console.error("Error al obtener los modos de pago:", error);
          Swal.fire("Error", "No se pudieron cargar los modos de pago.", "error");
        });
    },
    deletePayMode(id) {
      Swal.fire({
        title: `¿Deseas eliminar el modo de pago con ID ${id}?`,
        showCancelButton: true,
        confirmButtonText: "Eliminar",
        icon: "warning",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .delete(`http://127.0.0.1:8000/api/pay_modes/${id}`)
            .then((response) => {
              Swal.fire("¡Eliminado!", "Modo de pago eliminado correctamente.", "success");
              this.fetchPayModes(); // Refresca la tabla
            })
            .catch((error) => {
              console.error("Error al eliminar modo de pago:", error);
              Swal.fire("Error", "No se pudo eliminar el modo de pago.", "error");
            });
        }
      });
    },
    editPayMode(id) {
      this.$router.push({ name: "EditPayMode", params: { id: `${id}` } });
    },
    newPayMode() {
      this.$router.push({ name: "NewPayMode" });
    },
  },
  mounted() {
    this.fetchPayModes(); // Carga inicial
  },
};
</script>
