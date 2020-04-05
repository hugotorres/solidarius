<template>
  <div>
    <div
      class="side-panel"
      v-if="producto"
      v-bind:class="{ active: isActive , inactive: !isActive }"
    >
      <div class="side-content">
        <div class="content">
          <button type="button" class="close" aria-label="Close" v-on:click="toggle">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="row detalle">
            <div class="col-sm-12 text-justify py-2 d-flex justify-content-between">
              <div style="color:white;">
                <h3>
                  <i class="fa fa-venus" v-if="producto.gender=='f'"></i>
                  <i class="fa fa-mars" v-if="producto.gender=='m'"></i>
                  {{producto.text}} / {{producto.age}}
                </h3>
              </div>
              <div class="dates">
                <span>Se unio: hace {{days_between(new Date(producto.created_at),new Date())}} dias</span>
                <br />
                <span>Actualizado: hace {{days_between(new Date(producto.updated_at),new Date())}} dias</span>
              </div>
            </div>
            <!--  Carrusel de fotos -->
            <div class="col-sm-6 my-4">
              <div id="carouselExampleInterval" class="carousel slide mx-auto" data-ride="carousel">
                <div class="carousel-inner" v-if="detalles.image">
                  <div
                    class="carousel-item"
                    data-interval="10000"
                    v-for="(image,idx) in Object.keys(detalles.image)"
                    v-bind:key="idx"
                    :class="{ active: idx==0 || idx==null }"
                  >
                    <img
                      v-bind:src="'/uploads/profile/' + detalles.image[image]"
                      class="img-thumbnail slider-image"
                      alt="..."
                    />
                  </div>
                </div>
                <div class="default-image" v-if="!detalles.image">
                    No hay imagen
                </div>
                <a v-if="detalles.image"
                  class="carousel-control-prev"
                  href="#carouselExampleInterval"
                  role="button"
                  data-slide="prev"
                >
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a v-if="detalles.image"
                  class="carousel-control-next"
                  href="#carouselExampleInterval"
                  role="button"
                  data-slide="next"
                >
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
              <div class="d-flex justify-content-between">
                <a
                  :href="producto.whatsapp"
                  class="btn btn-success btn-sm whatsapp-btn contact-btn"
                >whatsapp</a>
                <a
                  :href="producto.phone_number"
                  class="btn btn-success btn-sm call-btn contact-btn"
                >Llamar</a>
              </div>
              <hr />
              <div class="d-flex justify-content-between">
                <a :href="producto.url_instagram" class="btn btn-info btn-sm contact-btn">Instagram</a>
                <a :href="producto.url" class="btn btn-info btn-sm contact-btn">Sitio Web</a>
              </div>
            </div>
            <div class="col-sm-6 my-4">
              <div class="product-description" v-html="producto.description"></div>
              <div class="category">{{producto.category}}</div>
              <div class="rating" v-show="producto.rating">{{producto.rating}}</div>
              <div class="horario">
                <i class="fa fa-calendar"></i>
                {{producto.horario}}
              </div>
              <div class="tarifa">
                <i class="fa fa-money"></i>
                {{producto.tarifa}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="default-content" v-bind:class="{ active: !isActive, inactive: isActive }">
      <div class="col">
        <div class="home-image text-center">
          <img src="/images/icon.png" alt />
          <h3>Solidarius</h3>
          <p>Colombiano ayuda Colombiano</p>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped lang="scss">
.carousel {
  height: 480px;
  .carousel-inner {
    height: 97%;
  }
}
.home-map-wrapper.row {
    overflow: hidden;
}
.row.detalle:after {
    content: "";
    height: 100%;
    width: 100%;
    background: #8f8f8f52;
    position: absolute;
    transform: rotate(45deg);
    left: 232px;
    z-index: -100;
}
*::before,
*::after {
  box-sizing: border-box;
  font-size: 17px;
}
button.close {
  background: black;
  /* padding: 20px; */
  transform: rotate(45deg);
  width: 30px;
  height: 30px;
  margin-top: 11px;
  color: white;
  span {
    transform: rotate(45deg);
  }
}
.contact-btn {
  width: 49%;
  padding: 7px;
  font-weight: bold;
}
.row.detalle:before {
  content: "";
  background: #b6000078;
  display: block;
  z-index: -100000000000;
  height: 400px;
  width: 236px;
  top: -201px;
  position: absolute;
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  transform: rotate(45deg);
  -webkit-transform-origin-x: rotate(45deg);
}
.home-image img {
  height: 300px;
  text-align: center;
  border-radius: 50%;
}
.inactive {
  display: none;
}
.active {
  display: block !important;
}
.side-panel {
  max-width: 100%;
  height: 100%;
  opacity: 1;
  .slider-image {
    height: auto;
  }
}
.product-image {
  border-radius: 50%;
  height: 120px;
  text-align: center;
  background: #e3e3e3;
}
.product-description {
  padding: 5px 20px;
  overflow: auto;
  background: #e7e7e72e;
  border-radius: 0 20px 20px 20px;
}
.toggle-panel.active {
  box-shadow: #c1b8b8 4px 5px 4px 1px;
  z-index: 2;
}
.toggle-panel {
  position: absolute;
  right: 0px;
  z-index: 1000;
  background: rgb(255, 1, 1);
  padding: 10px;
  transition: all 1s ease-in;
}
.side-panel.active {
  display: block;
  z-index: 10;
  opacity: 1;
}
.default-content {
  padding: 20px;
  .inactive {
    display: none;
  }
}
</style>

<script>
export default {
  name: "DetailsPanel",
  mounted() {
    this.detalles = this.producto;
  },
  updated() {
    this.detalles = this.producto;
  },
  data() {
    return {
      detalles: []
    };
  },
  methods: {

    toggle: function(event) {
      this.isActive = !this.isActive;
    },
    days_between: function(date1, date2) {
      // The number of milliseconds in one day
      const ONE_DAY = 1000 * 60 * 60 * 24;

      // Calculate the difference in milliseconds
      const differenceMs = Math.abs(date1 - date2);

      // Convert back to days and return
      return Math.round(differenceMs / ONE_DAY);
    }
  },
  props: ["isActive", "producto"]

};
</script>

