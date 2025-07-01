<template>
  <div class="contenedor-carrito">
    <button class="btn-cerrar" @click="$emit('cerrar')">✖</button>
    <h2 class="titulo">🛍️ Carrito de Compras</h2>

    <div v-if="carrito.length === 0" class="vacio">
      Tu carrito está vacío.
    </div>

    <div v-else class="lista-productos">
      <div v-for="(item, index) in carrito" :key="item.id" class="item">
        <img :src="`/images/${item.imagen}`" class="producto-img" />
        <div class="detalles">
          <h3>{{ item.nombre }}</h3>
          <p>Precio: S/. {{ parseFloat(item.precio).toFixed(2) }}</p>

          <div class="cantidad-control">
            <button @click="cambiarCantidad(item.id, -1)">➖</button>
            <span>{{ item.cantidad }}</span>
            <button @click="cambiarCantidad(item.id, 1)">➕</button>
          </div>

          <p class="subtotal">Subtotal: S/. {{ (parseFloat(item.precio) * item.cantidad).toFixed(2) }}</p>
        </div>
        <button class="btn-trash" @click="quitarProducto(item.id)">🗑️</button>
      </div>

      <div class="total">
        <h3>Total: S/. {{ total.toFixed(2) }}</h3>
        <button class="btn-pagar" @click="mostrarPago = true">💳 Pagar</button>
        <Pago v-if="mostrarPago" @cerrar="mostrarPago = false" />
      </div>
    </div>
  </div>
</template>

<script>
import Pago from './Pago.vue';

export default {
  name: 'Carrito',
  components: {
    Pago
  },
  data() {
    return {
      mostrarPago: false,
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
    cambiarCantidad(id, delta) {
      const item = this.carrito.find(p => p.id === id);
      if (!item) return;
      item.cantidad += delta;
      if (item.cantidad <= 0) {
        this.quitarProducto(id);
      } else {
        this.actualizarLocalStorage();
      }
    },
    quitarProducto(id) {
      let original = JSON.parse(localStorage.getItem('carrito')) || [];
      original = original.filter(p => p.id !== id);
      localStorage.setItem('carrito', JSON.stringify(original));
      this.cargarCarrito();
    },
    actualizarLocalStorage() {
      let nuevo = [];
      this.carrito.forEach(prod => {
        for (let i = 0; i < prod.cantidad; i++) {
          nuevo.push({
            id: prod.id,
            nombre: prod.nombre,
            precio: prod.precio,
            imagen: prod.imagen
          });
        }
      });
      localStorage.setItem('carrito', JSON.stringify(nuevo));
    }
  }
}
</script>


<style scoped>
.contenedor-carrito {
  padding: 1rem;
  width: 340px;
  background-color: white;
  box-shadow: -4px 0 10px rgba(0, 0, 0, 0.1);
  height: 100vh;
  overflow-y: auto;
  font-family: 'Segoe UI', sans-serif;
}

.titulo {
  margin-bottom: 1rem;
}

.btn-cerrar {
  float: right;
  background-color: transparent;
  border: none;
  font-size: 1.4rem;
  cursor: pointer;
  margin-top: -10px;
}

.vacio {
  text-align: center;
  color: #777;
  font-size: 1rem;
  margin-top: 2rem;
}

.lista-productos {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.item {
  display: flex;
  background-color: #f9f9f9;
  padding: 0.8rem;
  border-radius: 10px;
  align-items: center;
  position: relative;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}

.producto-img {
  width: 70px;
  height: 70px;
  object-fit: cover;
  border-radius: 8px;
  margin-right: 0.8rem;
}

.detalles {
  flex: 1;
}

.detalles h3 {
  margin: 0;
  font-size: 1rem;
  color: #333;
}

.detalles p {
  margin: 2px 0;
  font-size: 0.85rem;
}

.subtotal {
  font-weight: bold;
  color: #0c5;
}

.cantidad-control {
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 6px 0;
}

.cantidad-control button {
  background-color: #ddd;
  border: none;
  padding: 4px 8px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
}

.btn-trash {
  background-color: transparent;
  border: none;
  font-size: 1.2rem;
  cursor: pointer;
  color: #d00;
  margin-left: 0.5rem;
}

.total {
  border-top: 1px solid #ccc;
  padding-top: 1rem;
  margin-top: 1rem;
  text-align: right;
}

.btn-pagar {
  background-color: #0c5;
  color: white;
  padding: 8px 16px;
  border: none;
  border-radius: 8px;
  font-weight: bold;
  cursor: pointer;
  margin-top: 0.5rem;
}

.btn-pagar:hover {
  background-color: #0a4;
}
</style>
