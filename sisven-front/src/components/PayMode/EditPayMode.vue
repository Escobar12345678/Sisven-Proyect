<template>
  <div class="container text-start">
    <h1 class="text-primary fw-bold">Editar Modo de Pago</h1>
    <div class="card">
      <div class="card-header fw-bold">Datos del Modo de Pago</div>
      <div class="card-body">
        <form @submit.prevent="updatePayMode">
          <div class="row mb-3">
            <label for="name" class="form-label">Nombre:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="money-check-alt" />
              </div>
              <input
                type="text"
                class="form-control"
                id="name"
                v-model="payMode.name"
              />
            </div>
          </div>

          <div class="row mb-3">
            <label for="observation" class="form-label">Observación:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="sticky-note" />
              </div>
              <textarea
                class="form-control"
                id="observation"
                v-model="payMode.observation"
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
  name: "EditPayMode",
  data() {
    return {
      payMode: {
        id: null,
        name: '',
        observation: ''
      },
    };
  },
  methods: {
    cancel() {
      this.$router.push({ name: "PayModes" });
    },
    async updatePayMode() {
      try {
        const res = await axios.put(
          `http://127.0.0.1:8000/api/pay_modes/${this.payMode.id}`,
          this.payMode
        );
        if (res.status === 200) {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Modo de pago actualizado correctamente",
            showConfirmButton: false,
            timer: 2000,
          });
          this.$router.push({ name: "PayModes" });
        }
      } catch (error) {
        console.error("Error al actualizar modo de pago:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "No se pudo actualizar el modo de pago.",
        });
      }
    },
  },
 mounted() {
  const id = this.$route.params.id;          
  axios
    .get(`http://127.0.0.1:8000/api/pay_modes/${id}`)  
    .then((response) => {
      this.payMode = response.data.pay_mode;
      console.log("Loaded payMode:", this.payMode);
    })
    .catch((error) => {
      console.error("Error al obtener el modo de pago:", error);
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "No se pudo cargar la información del modo de pago.",
      });
    });
},

};
</script>
