<!-- resources/js/Componentes/App.vue -->
<template>
  <div class="contenedor">
    <header class="header">
      <h1 class="titulo">ElectroPerú 🛒</h1>
      <button @click="mostrarCarrito = true" class="btn-carrito">🛍️ Ver Carrito ({{ cantidadCarrito }})</button>
    </header>

    <Catalogo @producto-agregado="actualizarCarrito" />

    <div class="carrito-overlay" v-if="mostrarCarrito" @click.self="mostrarCarrito = false">
      <Carrito @cerrar="mostrarCarrito = false" />
    </div>
  </div>
</template>

<script>
import Catalogo from './Catalogo.vue'
import Carrito from './Carrito.vue'

export default {
  components: { Catalogo, Carrito },
  data() {
    return {
      mostrarCarrito: false,
      cantidadCarrito: 0
    }
  },
  mounted() {
    this.actualizarCarrito()
  },
  methods: {
    actualizarCarrito() {
      const datos = JSON.parse(localStorage.getItem('carrito')) || []
      this.cantidadCarrito = datos.length
    }
  }
}
</script>

<style scoped>
.contenedor {
  font-family: Arial, sans-serif;
}

.header {
  background-color: #0c5;
  color: white;
  padding: 1rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.titulo {
  margin: 0;
  font-size: 1.8rem;
}

.btn-carrito {
  background: white;
  color: #0c5;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  font-weight: bold;
  cursor: pointer;
}

.carrito-overlay {
  position: fixed;
  top: 0;
  right: 0;
  width: 400px;
  height: 100%;
  background-color: white;
  box-shadow: -4px 0 10px rgba(0,0,0,0.2);
  z-index: 999;
  overflow-y: auto;
  transition: transform 0.3s ease-in-out;
}
</style>
