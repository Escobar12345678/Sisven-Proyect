<template>
  <div class="container text-start">
    <h1 class="text-primary fw-bold">Nuevo Modo de Pago</h1>
    <div class="card">
      <div class="card-header fw-bold">Modo de Pago</div>
      <div class="card-body">
        <form @submit.prevent="savePayMode">
          <!-- Nombre -->
          <div class="row mb-3">
            <label for="name" class="form-label">Nombre:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="credit-card" />
              </div>
              <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Nombre del modo de pago"
                v-model="payMode.name"
                required
                maxlength="50"
              />
            </div>
          </div>

          <!-- Observación -->
          <div class="row mb-3">
            <label for="observation" class="form-label">Observación:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="note-sticky" />
              </div>
              <input
                type="text"
                class="form-control"
                id="observation"
                placeholder="Observación (opcional)"
                v-model="payMode.observation"
                maxlength="200"
              />
            </div>
          </div>

          <!-- Botones -->
          <button class="btn btn-primary" type="submit">Guardar</button>
          <button class="btn btn-secondary mx-2" @click="cancel">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
  name: "NewPayMode",
  data() {
    return {
      payMode: {
        name: "",
        observation: "",
      },
    };
  },
  methods: {
    cancel() {
      this.$router.push({ name: "PayModes" });
    },
    async savePayMode() {
      try {
        const res = await axios.post(
          "http://127.0.0.1:8000/api/pay_modes",
          this.payMode
        );
        if (res.status === 200 || res.status === 201) {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Modo de pago guardado con éxito",
            showConfirmButton: false,
            timer: 2000,
          });
          this.$router.push({ name: "PayModes" });
        }
      } catch (error) {
        console.error("Error guardando modo de pago:", error);
        let message = "No se pudo guardar el modo de pago.";
        if (
          error.response &&
          error.response.data &&
          error.response.data.msg
        ) {
          message = error.response.data.msg;
        }
        Swal.fire({
          icon: "error",
          title: "Error",
          text: message,
        });
      }
    },
  },
};
</script>
