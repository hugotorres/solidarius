<template>
  <div>
    <div class="d-none">
      <label>
        Busqueda:
        <gmap-autocomplete @place_changed="setPlace"></gmap-autocomplete>
      </label>
    </div>
    <gmap-map
      :center="center"
      :zoom="8"
      style="width:100%;  height: 90vh;"
      :options="{
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: true,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: false,
        disableDefaultUi: false,
        styles:grayStyle
        }"
    >
<!--       <gmap-info-window
        :options="infoOptions"
        :position="infoWindowPos"
        :opened="infoWinOpen"
        @closeclick="infoWinOpen=false"
      ></gmap-info-window> -->
      <gmap-marker
        :key="index"
        v-for="(m, index) in setupMarkers()"
        :position="m.position"
        :title="m.text"
         animation: google.maps.Animation.DROP
        @click="openDetails(m,index)"
        :icon="'/uploads/'+m.category_icon"
      >
      </gmap-marker>
    </gmap-map>

    <!--     <div class="side-panel">
            <detail-panel  :isActive="sidePanel" :producto="detailRequested"></detail-panel>
    </div>-->
  </div>
</template>

<script>
import DetailsPanel from "./DetailsPanel";
export default {
  name: "GoogleMap",
  watch: {
    $props: {
      handler() {
        console.log("´props changed");
        this.setupMarkers();
      },
      deep: true,
      immediate: true
    }
  },
  mounted() {},
  updated() {
    this.$attrs.markers = this.markers;
  },
  data() {
    return {
      grayStyle: [
        {
          elementType: "geometry",
          stylers: [
            {
              color: "#f5f5f5"
            }
          ]
        },
        {
          elementType: "labels.icon",
          stylers: [
            {
              visibility: "off"
            }
          ]
        },
        {
          elementType: "labels.text.fill",
          stylers: [
            {
              color: "#616161"
            }
          ]
        },
        {
          elementType: "labels.text.stroke",
          stylers: [
            {
              color: "#f5f5f5"
            }
          ]
        },
        {
          featureType: "administrative",
          elementType: "geometry",
          stylers: [
            {
              visibility: "off"
            }
          ]
        },
        {
          featureType: "administrative.land_parcel",
          elementType: "labels",
          stylers: [
            {
              visibility: "off"
            }
          ]
        },
        {
          featureType: "administrative.land_parcel",
          elementType: "labels.text.fill",
          stylers: [
            {
              color: "#bdbdbd"
            }
          ]
        },
        {
          featureType: "poi",
          stylers: [
            {
              visibility: "off"
            }
          ]
        },
        {
          featureType: "poi",
          elementType: "geometry",
          stylers: [
            {
              color: "#eeeeee"
            }
          ]
        },
        {
          featureType: "poi",
          elementType: "labels.text.fill",
          stylers: [
            {
              color: "#757575"
            }
          ]
        },
        {
          featureType: "poi.park",
          elementType: "geometry",
          stylers: [
            {
              color: "#e5e5e5"
            }
          ]
        },
        {
          featureType: "poi.park",
          elementType: "labels.text.fill",
          stylers: [
            {
              color: "#9e9e9e"
            }
          ]
        },
        {
          featureType: "road",
          elementType: "geometry",
          stylers: [
            {
              color: "#ffffff"
            }
          ]
        },
        {
          featureType: "road",
          elementType: "labels.icon",
          stylers: [
            {
              visibility: "off"
            }
          ]
        },
        {
          featureType: "road.arterial",
          elementType: "labels.text.fill",
          stylers: [
            {
              color: "#757575"
            }
          ]
        },
        {
          featureType: "road.highway",
          elementType: "geometry",
          stylers: [
            {
              color: "#dadada"
            }
          ]
        },
        {
          featureType: "road.highway",
          elementType: "labels.text.fill",
          stylers: [
            {
              color: "#616161"
            }
          ]
        },
        {
          featureType: "road.local",
          elementType: "labels",
          stylers: [
            {
              visibility: "off"
            }
          ]
        },
        {
          featureType: "road.local",
          elementType: "labels.text.fill",
          stylers: [
            {
              color: "#9e9e9e"
            }
          ]
        },
        {
          featureType: "transit",
          stylers: [
            {
              visibility: "off"
            }
          ]
        },
        {
          featureType: "transit.line",
          elementType: "geometry",
          stylers: [
            {
              color: "#e5e5e5"
            }
          ]
        },
        {
          featureType: "transit.station",
          elementType: "geometry",
          stylers: [
            {
              color: "#eeeeee"
            }
          ]
        },
        {
          featureType: "water",
          elementType: "geometry",
          stylers: [
            {
              color: "#c9c9c9"
            }
          ]
        },
        {
          featureType: "water",
          elementType: "labels.text.fill",
          stylers: [
            {
              color: "#9e9e9e"
            }
          ]
        }
      ],
      infoWindowPos: null,
      infoWinOpen: false,
      infoOptions: {
        content: "content of info window",
        //optional: offset infowindow so it visually sits nicely on top of our marker
        pixelOffset: {
          width: 0,
          height: -35
        }
      },
      shape: {
        coords: [10, 10, 10, 15, 15, 15, 15, 10],
        type: "poly"
      },
      infoOpened: false,
      center: { lat: 45.65, lng: -74.0417 },
      categories: this.setupCategories(),
      places: Array,
      currentPlace: null,
      sidePanel: false,
      detailRequested: {}
    };
  },
  components: {
    DetailsPanel
  },

  mounted() {
    this.geolocate();
  },
  computed: {
    filteredMarkers: function() {
      return this.setupMarkers();
    }
  },

  methods: {
    toggleInfoWindow: function(marker, idx) {
      this.infoWindowPos = marker.position;
      this.infoOptions.content = marker.infoText;

      //check if its the same marker that was selected if yes toggle
      if (this.currentMidx == idx) {
        this.infoWinOpen = !this.infoWinOpen;
      }
      //if different marker set infowindow to open and reset current marker index
      else {
        this.infoWinOpen = true;
        this.currentMidx = idx;
      }
    },
    openDetails(m, i) {
      this.detailRequested = m;
      this.$emit("clickMarker", m);
      this.toggleInfoWindow(m, i);
      // return m.position;
    },
    setPlace(place) {
      // this.currentPlace = place;
      console.log(place.geometry.location.lat());
      this.center = {
        lat: place.geometry.location.lat(),
        lng: place.geometry.location.lng()
      };
    },

    setupCategories() {
      let arreglo = [];
      let otroArreglo = [];
      $.each(this.$attrs.categories, function(key, category) {
        arreglo.push({
          icon: category.icon,
          name: category.title,
          id: category.id
        });
      });
      return arreglo;
    },
    setupMarkers() {
      let arreglo = [];
      const context = this;
      $.each(this.markers, function(key, product) {
        const marker = {
          lat: parseFloat(product.latitude),
          lng: parseFloat(product.longitude)
        };
        if (
          context.markersFilter &&  product.category_id == context.markersFilter
        )
          arreglo.push({
            position: marker,
            infoText:   "<h4>"+product.text+"</h4><div> </div><div class='vermas'>::: + info :::</div>", ...product
          });
        else if (!context.markersFilter) {
          arreglo.push({
            position: marker,
            infoText:
              "<h4>"+product.text+"</h4><div></div><div class='vermas'>::: + info :::</div>",...product
          });
        }
      });
      return arreglo;
    },
    addMarker() {
      if (this.currentPlace) {
        const marker = {
          lat: this.currentPlace.geometry.location.lat(),
          lng: this.currentPlace.geometry.location.lng()
        };
        this.markers.push({ position: marker });
        this.places.push(this.currentPlace);
        this.center = marker;
        this.currentPlace = null;
      }
    },
    geolocate: function() {
      navigator.geolocation.getCurrentPosition(position => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
      });
    }
  },
  props: ["markers", "markersFilter"]
};
</script>
