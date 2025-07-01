<template>
  <div class="modal-fondo" @click.self="$emit('cerrar')">
    <div class="modal-pago">
      <button class="cerrar" @click="$emit('cerrar')">✖</button>
      <h2>💳 Pago con Tarjeta</h2>

      <form @submit.prevent="procesarPago">
        <div class="form-group">
          <label>Nombre en la tarjeta:</label>
          <input type="text" v-model="nombre" required />
        </div>

        <div class="form-group">
          <label>Número de tarjeta:</label>
          <input type="text" v-model="tarjeta" maxlength="16" required />
        </div>

        <div class="form-group">
          <label>Fecha de vencimiento:</label>
          <input type="month" v-model="vencimiento" required />
        </div>

        <div class="form-group">
          <label>CVC:</label>
          <input type="text" v-model="cvc" maxlength="4" required />
        </div>

        <button class="btn-pagar" type="submit">Confirmar pago</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "Pago",
  data() {
    return {
      nombre: "",
      tarjeta: "",
      vencimiento: "",
      cvc: ""
    };
  },
  methods: {
    procesarPago() {
  this.$axios.post('/api/pago', {
    nombre: this.nombre,
    tarjeta: this.tarjeta,
    vencimiento: this.vencimiento,
    cvc: this.cvc
  })
  .then(res => {
    alert(res.data.mensaje);
    localStorage.removeItem('carrito'); // Limpia el carrito
    this.$emit('cerrar'); // Cierra modal
    window.location.reload(); // Opcional
  })
  .catch(err => {
    alert('❌ Error al procesar el pago');
    console.error(err);
  });
}

  }
};
</script>

<style scoped>
.modal-fondo {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
}

.modal-pago {
  background-color: white;
  padding: 2rem;
  border-radius: 12px;
  width: 320px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
  position: relative;
}

.cerrar {
  position: absolute;
  top: 10px;
  right: 14px;
  background: none;
  border: none;
  font-size: 1.2rem;
  cursor: pointer;
}

h2 {
  text-align: center;
  margin-bottom: 1rem;
}

.form-group {
  margin-bottom: 1rem;
}

input {
  width: 100%;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 6px;
}

.btn-pagar {
  width: 100%;
  background-color: #0c5;
  color: white;
  padding: 10px;
  border: none;
  border-radius: 8px;
  font-weight: bold;
  cursor: pointer;
}

.btn-pagar:hover {
  background-color: #094;
}
</style>
