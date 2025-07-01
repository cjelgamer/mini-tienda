<template>
  <div class="contenedor">
    <header class="header">
      <h1 class="titulo">Cristian Vendiendo 🛍️</h1>
    </header>

    <Catalogo @producto-agregado="actualizarCarrito" />

    <!-- Botón flotante de carrito -->
    <button @click="mostrarCarrito = true" class="btn-carrito-flotante">
      🛒 ({{ cantidadCarrito }})
    </button>

    <!-- Carrito desplegable -->
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
  font-family: 'Segoe UI', sans-serif;
  min-height: 100vh;
  background: radial-gradient(circle at 20% 20%, #e9f9ee, transparent 30%),
              radial-gradient(circle at 80% 40%, #dff7e4, transparent 40%),
              radial-gradient(circle at 60% 80%, #e1f2ea, transparent 50%);
  background-color: #f6fff9;
  padding-bottom: 80px; /* espacio para botón flotante */
}

.header {
  background-color: #0c5;
  color: white;
  padding: 1.5rem 2rem;
  text-align: center;
  border-bottom-left-radius: 25px;
  border-bottom-right-radius: 25px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.titulo {
  margin: 0;
  font-size: 2rem;
  letter-spacing: 1px;
}

/* Botón flotante del carrito */
.btn-carrito-flotante {
  position: fixed;
  bottom: 25px;
  right: 25px;
  background-color: #0c5;
  color: white;
  border: none;
  padding: 12px 18px;
  border-radius: 50px;
  font-size: 1.1rem;
  font-weight: bold;
  cursor: pointer;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
  z-index: 1000;
  transition: background 0.3s;
}

.btn-carrito-flotante:hover {
  background-color: #0a4;
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
