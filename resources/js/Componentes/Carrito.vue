<template>
  <div class="contenedor-carrito">
    <button class="btn-cerrar" @click="$emit('cerrar')">✖</button>
    <h2>🛍️ Carrito de Compras</h2>

    <div v-if="carrito.length === 0" class="vacio">
      Tu carrito está vacío.
    </div>

    <div v-else class="lista-productos">
      <div v-for="(item, index) in carrito" :key="item.id" class="item">
        <img :src="`/images/${item.imagen}`" class="producto-img" />
        <div class="detalles">
          <h3>{{ item.nombre }}</h3>
          <p>Precio unitario: S/. {{ parseFloat(item.precio).toFixed(2) }}</p>
          <p>Cantidad: {{ item.cantidad }}</p>
          <p>Total: S/. {{ (parseFloat(item.precio) * item.cantidad).toFixed(2) }}</p>
          <button @click="quitarProducto(item.id)">❌ Quitar</button>
        </div>
      </div>

      <div class="total">
        <h3>Total general: S/. {{ total.toFixed(2) }}</h3>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Carrito',
  data() {
    return {
      carrito: []
    }
  },
  computed: {
    total() {
      return this.carrito.reduce((sum, item) =>
        sum + parseFloat(item.precio) * item.cantidad, 0
      );
    }
  },
  mounted() {
    this.cargarCarrito();
  },
  methods: {
    cargarCarrito() {
      const guardado = localStorage.getItem('carrito');
      if (guardado) {
        const items = JSON.parse(guardado);

        // Agrupar productos por ID
        const agrupado = [];
        for (const producto of items) {
          const existente = agrupado.find(p => p.id === producto.id);
          if (existente) {
            existente.cantidad++;
          } else {
            agrupado.push({ ...producto, cantidad: 1 });
          }
        }

        this.carrito = agrupado;
      }
    },
    quitarProducto(id) {
      // Eliminar todas las ocurrencias de un producto
      let original = JSON.parse(localStorage.getItem('carrito')) || [];
      original = original.filter(p => p.id !== id);
      localStorage.setItem('carrito', JSON.stringify(original));
      this.cargarCarrito();
    }
  }
}
</script>

<style scoped>
.contenedor-carrito {
  padding: 1rem;
  width: 320px;
}

.btn-cerrar {
  float: right;
  background-color: transparent;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
}

.lista-productos {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.item {
  display: flex;
  gap: 1rem;
  border-bottom: 1px solid #ddd;
  padding-bottom: 1rem;
}

.producto-img {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 8px;
}

.detalles {
  flex: 1;
}

.detalles h3 {
  margin: 0;
  font-size: 1rem;
}

.detalles p {
  margin: 4px 0;
  font-size: 0.9rem;
}

.detalles button {
  background-color: #f44336;
  color: white;
  padding: 5px 10px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.total {
  text-align: right;
  font-weight: bold;
  font-size: 1.2rem;
  margin-top: 1rem;
}
</style>
