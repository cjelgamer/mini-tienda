<template>
  <div class="contenedor">
    <!-- Buscador -->
    <div class="buscador">
      <div class="input-con-icono">
        <input
          type="text"
          v-model="busqueda"
          placeholder="Buscar productos por nombre..."
          class="input-busqueda"
        />
        <span class="icono-lupa">🔍</span>
      </div>
    </div>

    <!-- Cargando o sin resultados -->
    <div v-if="productosFiltrados.length === 0" class="loading">
      No se encontraron productos.
    </div>

    <!-- Productos -->
    <div v-else class="productos">
      <div
        v-for="producto in productosFiltrados"
        :key="producto.id"
        class="producto"
      >
        <img
          :src="`/images/${producto.imagen}`"
          alt="Imagen"
          class="producto-img"
          @click="mostrarDetalle(producto)"
        />
        <h3 class="producto-nombre" @click="mostrarDetalle(producto)">
          {{ producto.nombre }}
        </h3>
        <p class="producto-precio">
          S/. {{ parseFloat(producto.precio).toFixed(2) }}
        </p>
        <button @click="agregarAlCarrito(producto)" class="btn-agregar">
          Agregar al carrito
        </button>
      </div>
    </div>

    <!-- Modal de detalle -->
    <DetalleProducto
      v-if="productoSeleccionado"
      :producto="productoSeleccionado"
      @cerrar="productoSeleccionado = null"
    />
  </div>
</template>

<script>
import axios from 'axios';
import DetalleProducto from './DetalleProducto.vue';

export default {
  name: 'Catalogo',
  components: {
    DetalleProducto
  },
  data() {
    return {
      productos: [],
      busqueda: '',
      productoSeleccionado: null
    };
  },
  computed: {
    productosFiltrados() {
      return this.productos.filter((p) =>
        p.nombre.toLowerCase().includes(this.busqueda.toLowerCase())
      );
    }
  },
  mounted() {
    axios
      .get('/productos')
      .then((res) => {
        this.productos = res.data;
      })
      .catch((err) => {
        console.error('Error al cargar productos:', err);
      });
  },
  methods: {
    agregarAlCarrito(producto) {
      let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
      carrito.push(producto);
      localStorage.setItem('carrito', JSON.stringify(carrito));
    },
    mostrarDetalle(producto) {
      this.productoSeleccionado = producto;
    }
  }
};
</script>

<style scoped>
body {
  margin: 0;
  background-color: #f9f9f9;
}

.contenedor {
  max-width: 1200px;
  margin: 2rem auto;
  padding: 0 2rem;
  font-family: "Segoe UI", sans-serif;
}

/* Buscador */
.buscador {
  display: flex;
  justify-content: center;
  margin-bottom: 2rem;
}

.input-con-icono {
  position: relative;
  width: 60%;
}

.input-busqueda {
  width: 100%;
  padding: 10px 40px 10px 16px;
  border-radius: 10px;
  border: 1px solid #ccc;
  font-size: 1rem;
  outline: none;
  transition: box-shadow 0.2s;
}

.input-busqueda:focus {
  box-shadow: 0 0 6px #0c5;
}

.icono-lupa {
  position: absolute;
  right: 14px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 1.2rem;
  color: #888;
}

.loading {
  text-align: center;
  font-size: 1.2rem;
  color: #999;
}

.productos {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 25px;
  margin-top: 1rem;
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
