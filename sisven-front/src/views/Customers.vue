<template>
  <div class="container">
    <h1>Listado Clientes</h1>
    <button @click="newCustomer()" class="btn btn-success mx-2">
      <font-awesome-icon icon="plus" /> Nuevo Cliente
    </button>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Documento</th>
          <th scope="col">Nombre</th>
          <th scope="col">Apellido</th>
          <th scope="col">Dirección</th>
          <th scope="col">Fecha de Nacimiento</th>
          <th scope="col">Teléfono</th>
          <th scope="col">Email</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(customer, index) in customers" :key="customer.id">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ customer.document_number }}</td>
          <td>{{ customer.first_name }}</td>
          <td>{{ customer.last_name }}</td>
          <td>{{ customer.address }}</td>
          <td>{{ customer.birthday }}</td>
          <td>{{ customer.phone_number }}</td>
          <td>{{ customer.email }}</td>
          <td>
            <button
              @click="deleteCustomer(customer.id)"
              class="btn btn-danger mx-2"
            >
              <font-awesome-icon icon="trash" />
            </button>
            <button
              @click="editCustomer(customer.id)"
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
  name: "CustomersList",
  data() {
    return {
      customers: [],
    };
  },
  methods: {
    fetchCustomers() {
      axios
        .get("http://127.0.0.1:8000/api/customers")
        .then((response) => {
          this.customers = response.data.customers;
        })
        .catch((error) => {
          console.error("Error fetching customers:", error);
        });
    },
    deleteCustomer(codigo) {
      Swal.fire({
        title: `¿Deseas eliminar el cliente con ID ${codigo}?`,
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        icon: 'warning',
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(`http://127.0.0.1:8000/api/customers/${codigo}`)
            .then(response => {
              if (response.status === 200 || response.status === 204 || response.data.success) {
                Swal.fire('¡Eliminado!', 'El cliente fue eliminado correctamente.', 'success');
                this.fetchCustomers(); // Recarga los datos
              }
            })
            .catch(error => {
              console.error("Error eliminando cliente:", error);
              Swal.fire('Error', 'No se pudo eliminar el cliente.', 'error');
            });
        }
      });
    },
    editCustomer(id) {
      this.$router.push({ name: 'EditCustomer', params: { id: `${id}` } });
    },
    newCustomer() {
      this.$router.push({ name: 'NewCustomer' });
    }
  },
  mounted() {
    this.fetchCustomers(); // Llamada inicial al cargar el componente
  }
};
</script>
