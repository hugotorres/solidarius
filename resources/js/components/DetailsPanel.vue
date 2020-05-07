<template>
  <div>
    <div class="side-panel" v-show="isActive" style="height:50vh">
      <div class="side-content">
        <div class="content">
          <button type="button" class="close" aria-label="Close" v-on:click="toggle">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="row detalle">
            <div class="col-sm-12 text-justify py-2 d-flex justify-content-between">
              <div class="company-name">
                <h4 style="text-transform: capitalize;">{{producto.text}}</h4>
              </div>
              <div class="dates">
                <!-- <span>Actualizado: hace {{days_between(new Date(producto.updated_at),new Date())}} dias</span> -->
               {{producto.rating}}
              </div>
            </div>
            <div class="col-sm-6 my-4 datos-contacto">
              <div class="category">Datos de contacto:</div>
              <div class="">
                <a
                  v-if="producto.whatsapp  !== ''"
                  :href="producto.whatsapp"
                  class="btn btn-success btn-sm whatsapp-btn contact-btn "
                >
               
                whatsapp</a><br>
                <a
                  v-if="producto.phone_number!== ''"
                  :href="producto.phone_number"
                  class="btn btn-success btn-sm call-btn contact-btn  "
                >Llamar</a><br>
                <a
                  v-if="producto.url_instagram   !== ''"
                  :href="producto.url_instagram"
                  class="btn btn-success btn-sm contact-btn  "
                >
                <img   alt="instagram" width="30" height="30" class="pull-left"
                src="data:image/png;base64,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">
                Instagram</a><br>
                <a
                  v-if="producto.url   != ''"
                  :href="producto.url"
                  class="btn btn-success btn-sm contact-btn  "
                >Sitio Web</a>
              </div>
            </div>
            <div class="col-sm-6 my-4 slider-imagenes">
              <!-- <div class="horario">
                <i class="fa fa-calendar"></i>
                {{producto.horario}}
              </div>
              <div class="tarifa">
                <i class="fa fa-money"></i>
                {{producto.tarifa}}
              </div>-->

              <div id="carouselExampleInterval" class="carousel slide mx-auto" data-ride="carousel">
                <div class="carousel-inner" v-if="producto.image">
                  <div
                    class="carousel-item"
                    data-interval="10000"
                    v-for="(image,idx) in Object.keys(producto.image)"
                    v-bind:key="idx"
                    :class="{ active: idx==0 || idx==null }"
                  >
                    <img
                      v-bind:src="'/uploads/profile/' + producto.image[image]"
                      class="img-thumbnail slider-image"
                      alt="..."
                    />
                  </div>
                </div>
                <div class="default-image" v-if="!producto.image">
                  <img src="images/default.png" alt="default" width="80%" />
                </div>
                <a
                  v-if="producto.image"
                  class="carousel-control-prev"
                  href="#carouselExampleInterval"
                  role="button"
                  data-slide="prev"
                >
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a
                  v-if="producto.image"
                  class="carousel-control-next"
                  href="#carouselExampleInterval"
                  role="button"
                  data-slide="next"
                >
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
            <div class="col-sm-12 description-box">
              <label for="description">Descripcion:</label>
              <div class="product-description" id="description" v-html="producto.description"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <default-details-panel
      :isActive="isActive"
      :categories="getOrderedCategories"
      v-on:searchCategory="searchCat"
    ></default-details-panel>
  </div>
</template>
<style scoped lang="scss">
.carousel {
  .carousel-inner {
    height: 97%;
  }
}
.home-map-wrapper.row {
  overflow: hidden;
}
.row.detalle {
  overflow: auto;
  height: 85vh;
}

*::before,
*::after {
  box-sizing: border-box;
  font-size: 17px;
}
button.close {
  background: black;
  /* padding: 20px; */
  width: 30px;
  height: 30px;
  margin-top: 11px;
  color: white;
  span {
    transform: rotate(45deg);
  }
}
.contact-btn { 
  padding: 7px;
  font-weight: bold;
}
.row.detalle:before {
  content: "";
  //background: #b6000028;
  display: block;
  z-index: -100000000000;
  height: 400px;
  width: 236px;
  top: -201px;
  position: absolute;
  // -webkit-transform: rotate(45deg);
  //-moz-transform: rotate(45deg);
  //transform: rotate(45deg);
  //-webkit-transform-origin-x: rotate(45deg);
}
.row .detalle h4 {
  color: black;
}
.home-image img {
  height: 150px;
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
  padding-top: 20vh;
  .inactive {
    display: none;
  }
}
</style>

<script>
import DefaultDetailsPanel from "./DefaultDetailsPanel";
export default {
  name: "DetailsPanel",
  components: {
    DefaultDetailsPanel
  },
  computed: {
    getOrderedCategories: function() {
      var ordenadas = [];
      Object.values(this.categories).forEach((element, index) => {
        ordenadas.push(element);
        if (element["0"]) {
          ordenadas[index]["subs"] = [];
          ordenadas[index]["subs"].push(element["0"]);
        }
      });
      return ordenadas;
    }
  },

  mounted() {
    this.detalles = this.producto;
  },
  data() {
    return {
      searchTerm: null,
      selectedCategory: null,
      orderedCategories: this.orderCategories(),
      detalles: []
    };
  },
  methods: {
    searchCat: function(e) {
      console.log(e);
      this.$emit("search", e);
    },
    selectCategoryBreadcrumb: function(cat) {
      this.selectedCategory = cat;
      event.preventDefault();
      this.$emit("search", cat.id);
      return false;
    },
    orderCategories: function() {
      var ordenadas = [];
      Object.values(this.categories).forEach((element, index) => {
        ordenadas.push(element);
        if (element["0"]) {
          ordenadas[index]["subs"] = [];
          ordenadas[index]["subs"].push(element["0"]);
        }
      });
      return ordenadas;
    },

    toggle: function(event) {
      console.log("togle", this.detalles);
      this.isActive = false;
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
  props: ["isActive", "producto", "categories"]
};
</script>

