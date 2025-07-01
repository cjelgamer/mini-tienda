<template>
  <div class="contenedor">
    <header class="header">
      <h1 class="titulo">ElectroPeru 🛒</h1>
      <nav>
        <button @click="$emit('abrir-carrito')" class="nav-link">🛍️ Ver carrito</button>
      </nav>
    </header>

    <div v-if="productos.length === 0" class="loading">Cargando productos...</div>

    <div v-else class="productos">
      <div v-for="producto in productos" :key="producto.id" class="producto">
        <img :src="`/images/${producto.imagen}`" alt="Imagen" class="producto-img" />
        <h3 class="producto-nombre">{{ producto.nombre }}</h3>
        <p class="producto-precio">S/. {{ producto.precio }}</p>
        <button @click="agregarAlCarrito(producto)" class="btn-agregar">Agregar al carrito</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Catalogo',
  data() {
    return {
      productos: [],
    };
  },
  mounted() {
    axios.get('/productos')
      .then(res => {
        this.productos = res.data;
      })
      .catch(err => {
        console.error('Error al cargar productos:', err);
      });
  },
  methods: {
    agregarAlCarrito(producto) {
  let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
  carrito.push(producto); // Puedes mantener esto si haces la agrupación luego en Carrito.vue
  localStorage.setItem('carrito', JSON.stringify(carrito));
}

  }
};
</script>

<style scoped>
body {
  margin: 0;
  background-color: #f9f9f9;
}

.header {
  background-color: #0c5;
  color: white;
  padding: 1rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-radius: 0 0 15px 15px;
}

.nav-link {
  color: white;
  font-weight: bold;
  text-decoration: none;
  background-color: #fff2;
  padding: 6px 12px;
  border-radius: 8px;
  transition: background 0.3s;
  border: none;
  cursor: pointer;
}

.nav-link:hover {
  background-color: #fff5;
}

.contenedor {
  max-width: 1200px;
  margin: 2rem auto;
  padding: 0 2rem;
  font-family: "Segoe UI", sans-serif;
}

.titulo {
  font-size: 1.8rem;
}

.loading {
  text-align: center;
  font-size: 1.2rem;
}

.productos {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 25px;
  margin-top: 2rem;
}

.producto {
  background-color: white;
  border: 1px solid #ddd;
  border-radius: 14px;
  padding: 1rem;
  text-align: center;
  box-shadow: 0 2px 10px rgba(0,0,0,0.06);
  transition: transform 0.2s;
}

.producto:hover {
  transform: scale(1.02);
}

.producto-img {
  width: 100%;
  height: 160px;
  object-fit: contain;
  margin-bottom: 1rem;
}

.producto-nombre {
  font-size: 1.2rem;
  margin: 0.5rem 0;
  color: #111;
}

.producto-precio {
  color: #0a5;
  font-weight: bold;
  margin-bottom: 1rem;
}

.btn-agregar {
  background-color: #0c5;
  color: white;
  padding: 8px 14px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.3s;
}

.btn-agregar:hover {
  background-color: #094;
}
</style>
