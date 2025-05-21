<template>
  <div class="container text-start">
    <h1 class="text-primary fw-bold">Nuevo Cliente</h1>
    <div class="card">
      <div class="card-header fw-bold">Cliente</div>
      <div class="card-body">
        <form @submit.prevent="saveCustomer">
          <!-- Documento -->
          <div class="row mb-3">
            <label for="document_number" class="form-label">Número de Documento:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="id-card" />
              </div>
              <input
                type="text"
                class="form-control"
                id="document_number"
                placeholder="Número de documento"
                v-model="customer.document_number"
              />
            </div>
          </div>

          <!-- Nombre -->
          <div class="row mb-3">
            <label for="first_name" class="form-label">Nombre:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="user" />
              </div>
              <input
                type="text"
                class="form-control"
                id="first_name"
                placeholder="Nombre"
                v-model="customer.first_name"
              />
            </div>
          </div>

          <!-- Apellido -->
          <div class="row mb-3">
            <label for="last_name" class="form-label">Apellido:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="user" />
              </div>
              <input
                type="text"
                class="form-control"
                id="last_name"
                placeholder="Apellido"
                v-model="customer.last_name"
              />
            </div>
          </div>

          <!-- Dirección -->
          <div class="row mb-3">
            <label for="address" class="form-label">Dirección:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="map-marker-alt" />
              </div>
              <input
                type="text"
                class="form-control"
                id="address"
                placeholder="Dirección"
                v-model="customer.address"
              />
            </div>
          </div>

          <!-- Fecha de nacimiento -->
          <div class="row mb-3">
            <label for="birthday" class="form-label">Fecha de nacimiento:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="calendar" />
              </div>
              <input
                type="date"
                class="form-control"
                id="birthday"
                v-model="customer.birthday"
              />
            </div>
          </div>

          <!-- Teléfono -->
          <div class="row mb-3">
            <label for="phone_number" class="form-label">Teléfono:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="phone" />
              </div>
              <input
                type="text"
                class="form-control"
                id="phone_number"
                placeholder="Teléfono"
                v-model="customer.phone_number"
              />
            </div>
          </div>

          <!-- Email -->
          <div class="row mb-3">
            <label for="email" class="form-label">Email:</label>
            <div class="input-group">
              <div class="input-group-text">
                <font-awesome-icon icon="envelope" />
              </div>
              <input
                type="email"
                class="form-control"
                id="email"
                placeholder="Correo electrónico"
                v-model="customer.email"
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
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: 'NewCustomer',
  data() {
    return {
      customer: {
        document_number: '',
        first_name: '',
        last_name: '',
        address: '',
        birthday: '',
        phone_number: '',
        email: ''
      },
    };
  },
  methods: {
    cancel() {
      this.$router.push({ name: 'Customers' });
    },
    async saveCustomer() {
      try {
        const res = await axios.post('http://127.0.0.1:8000/api/customers', this.customer);
        if (res.status === 200 || res.status === 201) {
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Cliente guardado con éxito',
            showConfirmButton: false,
            timer: 2000
          });
          this.$router.push({ name: 'Customers' });
        }
      } catch (error) {
        console.error(error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudo guardar el cliente'
        });
      }
    }
  }
};
</script>
