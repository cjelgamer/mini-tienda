<template>
  <div class="modal-fondo">
    <div class="modal">
      <button class="btn-cerrar" @click="$emit('cerrar')">✖</button>
      <h2>{{ producto.nombre }}</h2>
      <img :src="`/images/${producto.imagen}`" alt="imagen" class="imagen-modal" />
      <p><strong>Precio:</strong> S/. {{ parseFloat(producto.precio).toFixed(2) }}</p>
      <p><strong>Descripción:</strong> {{ producto.descripcion }}</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    producto: Object
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
  background-color: rgba(0,0,0,0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.modal {
  background-color: white;
  padding: 2rem;
  border-radius: 12px;
  width: 400px;
  max-width: 90%;
  text-align: center;
  position: relative;
}

.imagen-modal {
  width: 100%;
  height: 200px;
  object-fit: contain;
  margin-bottom: 1rem;
}

.btn-cerrar {
  position: absolute;
  top: 10px;
  right: 12px;
  font-size: 1.4rem;
  background: none;
  border: none;
  cursor: pointer;
}
</style>
