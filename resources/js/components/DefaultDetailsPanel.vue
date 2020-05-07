<template>
  <div class="default-content row" v-show="!isActive">
    <div class="col-sm-6">
      <div class="home-image text-center">
        <img src="/images/undraw_people_search_wctu.svg" alt="solidarius" />
      </div>
      <div class="card-body">
        <div class="input-group mb-3">
          <input
            type="text"
            class="form-control"
            v-model="searchTerm"
            placeholder="Termino de busqueda"
            aria-label="Termino de busqueda"
            aria-describedby="basic-addon2"
            @change="$emit('search', searchTerm);"
          />
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button">Buscar</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <h3>NecesiTu</h3>
      <p>
        <b>Yo lo necesito, tu lo tienes</b>
        Somos una plataforma que tiene como principal
        objetivo impulsar economias informales y formales (MiPymes y Pymes) de forma gratuita.
      </p>
    </div>
    <div class="col-sm-12">
      <div class="card-body">
        Filtrar por categoria
        <select
          class="custom-select"
          v-model="selectedCategory"
          @change="selectCategory"
        >
          <option selected :value="0">Seleccione una categoria</option>
          <option
            :value="category"
            v-for="category in categories"
            :key="category.id"
          >{{category.title}}</option>
        </select>
      </div>
    </div>
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
  width: 49%;
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
export default {
  name: "DefaultDetailsPanel.vue",

  data() {
    return {
      selectedCategory: null,

      searchTerm: null
    };
  },
  methods: {
    selectCategory: function() {
        this.isActive=false;
      event.preventDefault();
      this.$emit("searchCategory", this.selectedCategory.id);
      
      return false;
    },

    toggle: function(event) {
      console.log("togle", this.detalles);
      this.isActive = false;
    }
  },
  props: ["isActive", "categories"]
};
</script>

