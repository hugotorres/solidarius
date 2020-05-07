<template>
  <div class="container-fluid home-map-wrapper row">
    <!--     <multipane class="foo" layout="vertical">
      <div :style="{ width: '100%' }" v-bind:class="mapClass">
        <google-map v-on:clickMarker="clickMarker" :markers="products" :categories="categories"></google-map>
      </div>

      <multipane-resizer></multipane-resizer>

      <div :style="{ flexGrow: 1,maxWidth:'50%',minWidth:'50%' }">
        <detail-panel :isActive="sidePanel" :producto="detailRequested" v-if="detailRequested"></detail-panel>
      </div>
    </multipane>-->

    <div class="col-sm-8 mapa">
      <div>
        <google-map
          v-on:clickMarker="clickMarker"
          :markersFilter="selectedCategory"
          :markers="products"
          :categories="categories"
        ></google-map>
      </div>
    </div>

    <div class="col-sm-4 detalles">
      <div>
        <detail-panel
          :isActive="sidePanel"
          :categories="categories"
          :producto="detailRequested"
          v-if="detailRequested"
          v-on:search="searchMarkers"
        ></detail-panel>
      </div>
    </div>
  </div>
</template>

<script>
import GoogleMap from "./GoogleMap";
import { Multipane, MultipaneResizer } from "vue-multipane";
import DetailsPanel from "./DetailsPanel";
export default {
  computed: {
    filteredProducts: function() {
      return this.products;
    }
  },
  data() {
    return {
      products: this.$attrs.products,
      categories: this.$attrs.categories,
      sidePanel: false,
      detailRequested: {},
      mapClass: "closed",
      searchTerm: null,
      selectedCategory: null
    };
  },
  name: "HomeMap",
  mounted() {},
  components: {
    GoogleMap,
    DetailsPanel,
    Multipane,
    MultipaneResizer
  },
  methods: {
    searchMarkers(event) {
      console.log(event);
      this.filterMarkersByCategory(event);
    },
    filterMarkersByCategory(cat) {
      this.selectedCategory = cat;
      this.$attrs.products = [];
    },
    clickMarker(event) {
      this.sidePanel = true;
      this.detailRequested = event;
      this.mapClass = "open";
    }
  }
};
</script>
<style lang=scss  >
div #navbarSupportedContent:before {
  content: "";
  background: #ff00001c;
  height: 95px;
  width: 95px;
  top: -95px;
  left: 90%;
  position: absolute;
  transform: rotate(45deg);
  z-index: 0;
}
i {
  padding: 5px;
}
.open {
  width: 70%;
}
.closed {
  width: 98% !important;
}
.multipane.foo.layout-h .multipane-resizer {
  margin: 0;
  top: 0; /* reset default styling */
  background: blue;
  height: 400px !important;
}
.custom-resizer {
  width: 100%;
  height: 400px;
}
.pane {
  text-align: left;
  padding: 15px;
  overflow: hidden;
  background: #eee;
  border: 1px solid #ccc;
}
.pane ~ .pane {
  background: black;
}
.multipane-resizer {
  height: 400px !important;

  &:before {
    display: block;
    content: "";
    width: 3px;
    height: 40px;
    position: absolute;
    top: 50%;
    left: 50%;
    margin-left: -1.5px;
    border-left: 1px solid #ccc;
    border-right: 1px solid #ccc;
  }
  &:hover {
    &:before {
      border-color: #999;
    }
  }
}
</style>
