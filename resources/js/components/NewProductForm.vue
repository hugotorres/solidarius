<template>
  <div class="container my-4" v-if="profileData">
    <div
      class="alert alert-warning alert-dismissible fade show"
      role="alert"
      v-if="notification !== ''"
    >
      {{ notification }}
      <button
        type="button"
        class="close"
        @click="notification = ''"
        aria-label="Close"
      >
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a
              class="nav-link active"
              id="home-tab"
              data-toggle="tab"
              href="#home"
              role="tab"
              aria-controls="home"
              aria-selected="true"
            >Perfil</a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              id="profile-tab"
              data-toggle="tab"
              href="#profile"
              role="tab"
              aria-controls="profile"
              aria-selected="false"
            >Fotos</a>
          </li>
          <li class="nav-item hidden">
            <a
              class="nav-link"
              id="contact-tab"
              data-toggle="tab"
              href="#contact"
              role="tab"
              aria-controls="contact"
              aria-selected="false"
            >Contacto</a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div
            class="tab-pane fade show active"
            id="home"
            role="tabpanel"
            aria-labelledby="home-tab"
          >
            <form @submit="formSubmit" name="new-product" id="new-product" class="form-horizontal">
              <div class="row">
                <div class="col-sm-6 my-4">
                  <h5>Selecciona tu ubicaci?n actual:</h5>
                  <google-map-form v-on:updatePosition="updatePosition"></google-map-form>

                  <hr />
                  <label for="description" class="col-sm-2 control-label">Descripcion</label>
                  <ckeditor :editor="editor" v-model="profile.description" :config="editorConfig"></ckeditor>
                </div>
                <div class="col-sm-6 my-4">
                  <div class="form-group">
                    <label for="text" class="col-sm-2 control-label">Nombre</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        id="text"
                        v-model="profile.text"
                        name="text"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>
                  <multiselect
                    v-model="profile.category_id"
                    :options="cateogryOptions"
                    :multiple="true"
                    group-values="libs"
                    group-label="language"
                    :group-select="true"
                    placeholder="Seleccione una o varias categorias."
                    track-by="name"
                    label="name"
                  >
                    <span
                      slot="noResult"
                    >Oops! No elements found. Consider changing the search query.</span>
                  </multiselect>

                  <!-- <div class="form-group">
                    <label for="text" class="col-sm-2 control-label">Tarifa</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        id="tarifa"
                        v-model="profile.tarifa"
                        name="tarifa"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="text" class="col-sm-2 control-label">Horario</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        id="horario"
                        v-model="profile.horario"
                        name="horario"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>-->
                  <div class="form-group">
                    <label for="text" class="col-sm-2 control-label">Tags</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        id="tags"
                        v-model="profile.tags"
                        name="tags"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="text" class="col-sm-2 control-label">whatsapp</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        id="whatsapp"
                        v-model="profile.whatsapp"
                        name="text"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="text" class="col-sm-2 control-label">Telefono</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        id="phone_number"
                        v-model="profile.phone_number"
                        name="text"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="url_instagram" class="col-sm-2 control-label">Url</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        id="url_instgram"
                        name="url_instagram"
                        v-model="profile.url_instagram"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>

                  <div class="images-form">
                    <div class="form-group">
                      <label v-if="tempImages.length > 0" for="image" class="col-sm-2 control-label">Selected Files</label>

                      <table v-if="tempImages.length > 0" class="table">
                        <thead class="thead-light">
                          <td>Filename</td>
                          <td>Size</td>
                          <td>Type</td>
                        </thead>
                        <tbody>
                          <tr
                            class="selected-files"
                            v-for="file in tempImages"
                            v-bind:key="file.id"
                          >
                            <td class="filename">{{ file.name }}</td>
                            <td class="size">{{ file.size }}</td>
                            <td class="type">{{ file.type }}</td>
                          </tr>
                        </tbody>
                      </table>
                      <div class="col-sm-10">
                        <div class="box">
                          <input
                            @change="fileSelected"
                            type="file"
                            name="files"
                            id="file-1"
                            class="inputfile inputfile-1"
                            data-multiple-caption="{count} files selected"
                            multiple
                            accept="image/*"
                          />
                          <label for="file-1">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="20"
                              height="17"
                              viewBox="0 0 20 17"
                            >
                              <path
                                d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"
                              />
                            </svg>
                            <span>
                              Choose a
                              file&hellip;
                            </span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <!--  <div
                            class="container col-sm-8 text-center center-block"
                        >
                            <button
                                @click="formSubmit"
                                type="submit"
                                class="btn btn-success btn-lg btn-block"
                            >
                                Guardar Cambios
                            </button>
                    </div>-->
                    <hr />
                    <div class="col-sm-12">
                      <div
                        class="imagen preview-image"
                        v-for="item in filterImages(
                                                    profileData.image
                                                )"
                        v-bind:key="item.id"
                      >
                        <a
                          @click="
                                                        deleteImage(
                                                            item,
                                                            item.id
                                                        )
                                                    "
                          class="button btn-sm btn-outline-danger"
                        >
                          <span aria-hidden="true">&times;</span>
                        </a>
                        <img
                          :src="
                                                        '/uploads/profile/' +
                                                            item
                                                    "
                          alt
                        />
                      </div>
                    </div>
                  </div>
                  <!-- <div class="form-group">
                    <label for="text" class="col-sm-2 control-label">Servicios</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        id="servicios"
                        v-model="profile.servicios"
                        name="servicios"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>-->
                  <div class="form-group">
                    <label for="category" class="col-sm-2 control-label">Categoria</label>
                    <div class="col-sm-10">
                      <select
                        class="form-control"
                        id="category"
                        name="category"
                        v-model="profile.category_id"
                        required
                      >
                        <option value selected>---Seleccione categoria</option>
                        <option
                          v-for="{title, description, id} in categories"
                          :key="id"
                          v-bind:value="id"
                        >{{title}}</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="container my-4">
                  <div class="container col-sm-8 text-center center-block">
                    <button
                      type="submit"
                      class="btn btn-success btn-lg btn-block"
                      @click="formSubmit"
                    >Guardar Cambios</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div
            class="tab-pane fade"
            id="profile"
            role="tabpanel"
            aria-labelledby="profile-tab"
            v-if="profileData"
          ></div>
        </div>

        <!--  -->
      </div>
    </div>
  </div>
</template>
<style scoped lang="scss">
.preview-image {
  float: left;
  width: 30%;
  border-radius: 10px;
  border: thin solid white;
  img {
    width: 100%;
    border-radius: 10px;
    border: thin solid white;
  }
  .button {
    position: absolute;
    background: #c24e4e;
    color: white;
    padding: 10px;
    box-shadow: #615e5e 2px 2px 9px;
    border-radius: 5px !important;
    cursor: pointer;
  }
}
.inputs-box {
  box-shadow: inset #dcdcdc 0px 0px 10px 1px;
  border-radius: 11px;
  padding: 10px;
}
.form-box {
  border-radius: 20px;
  padding: 10px;
  box-shadow: #e2e2e2 0px 2px 8px 4px;
}
.form-control {
  border: none;
  background-color: #ffffff00;
  border-bottom: thin solid black;
  border-radius: 0;
}
input#file-1 {
  visibility: hidden;
}
.js .inputfile {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}

.inputfile + label {
  max-width: 80%;
  font-size: 1.25rem;
  /* 20px */
  font-weight: 700;
  text-overflow: ellipsis;
  white-space: nowrap;
  cursor: pointer;
  display: inline-block;
  overflow: hidden;
  padding: 0.625rem 1.25rem;
  /* 10px 20px */
}

.no-js .inputfile + label {
  display: none;
}

.inputfile:focus + label,
.inputfile.has-focus + label {
  outline: 1px dotted #000;
  outline: -webkit-focus-ring-color auto 5px;
}

.inputfile + label * {
  /* pointer-events: none; */
  /* in case of FastClick lib use */
  border-bottom: thin solid lightgray;
}

.inputfile + label svg {
  width: 1em;
  height: 1em;
  vertical-align: middle;
  fill: currentColor;
  margin-top: -0.25em;
  /* 4px */
  margin-right: 0.25em;
  /* 4px */
}
.hidden {
  position: absolute;
  overflow: hidden;
  width: 0;
  height: 0;
  pointer-events: none;
}

/* style 1 */

.inputfile-1 + label {
  color: #f1e5e6;
  background-color: #d3394c;
}

.inputfile-1:focus + label,
.inputfile-1.has-focus + label,
.inputfile-1 + label:hover {
  background-color: #722040;
}
</style>

<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
  components: {},
  data() {
    return {
      editor: ClassicEditor,
      editorData: "<p>Ingrese la descripcion de su producto o servicio</p>",
      editorConfig: {},
      show: true,
      notification: "",
      profileData: {},
      tempImages: [],
      output: "",
      categoryOptions: [
        {
          language: "Javascript",
          libs: [
            { name: "Vue.js", category: "Front-end" },
            { name: "Adonis", category: "Backend" }
          ]
        },
        {
          language: "Ruby",
          libs: [
            { name: "Rails", category: "Backend" },
            { name: "Sinatra", category: "Backend" }
          ]
        },
        {
          language: "Other",
          libs: [
            { name: "Laravel", category: "Backend" },
            { name: "Phoenix", category: "Backend" }
          ]
        }
      ]
    };
  },

  mounted() {
    this.profileData = this.profile;
  },
  props: ["profile", "categories"],
  ready: function() {
    this.profileData = this.profile;
    this.categories = JSON.parse(categories);
  },
  methods: {
    getInputValue() {
      if (this.profile.text && this.profile.category_id && this.profile.image)
        return true;
      else return false;
    },
    uploadImage(event) {
      const URL = "/api/profile/upload";

      let data = new FormData();
      data.append("name", "my-picture");
      data.append("file", event.target.files[0]);

      let config = {
        header: {
          "Content-Type": "image/png"
        }
      };

      axios
        .put(URL, data, config)
        .then(response => {
          console.log("image upload response > ", response);
        })
        .then(response => alert(response));
    },
    deleteImage(image, index) {
      let data = new FormData();
      data.append("image", image);
      data.append("index", index);
      axios.post("profile/image/", data).then(response => {
        this.profileData = response.data.profile;
        this.notification = response.data.success;
        console.log("image deleted  > ", response);
      });
    },

    formSubmit(e) {
      e.preventDefault();
      let formData = new FormData();

      let container = this;
      if (this.profileData.images)
        Object.keys(this.profileData.images).forEach(appendImage);

      function appendImage(item, index) {
        formData.append(
          "image[" + index + "]",
          container.profileData.images[index]
        );
      }
      formData.append("id", this.profile.id);
      formData.append("user_id", this.profile.user_id);

      formData.append("latitude", this.profile.latitude);
      formData.append("tags", this.profile.tags);
      formData.append("servicios", this.profile.servicios);
      formData.append("longitude", this.profile.longitude);
      formData.append("description", this.profile.description);
      formData.append("whatsapp", this.profile.whatsapp);
      formData.append("url", this.profile.url);
      formData.append("url_instagram", this.profile.url_instagram);
      formData.append("phone_number", this.profile.phone_number);
      formData.append("tarifa", this.profile.tarifa);
      formData.append("horario", this.profile.horario);
      formData.append("text", this.profile.text);
      formData.append("category_id", this.profile.category_id);

      let currentObj = this;
      const toaster = this.$toast;
      this.axios
        .post("/api/profile/create", formData)
        .then(function(response) {
          //currentObj.notification = response.data.success;

          toaster.success("Datos guardados!", {
            position: "top-left",
            timeout: 7333,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: false,
            draggablePercent: 1.85,
            showCloseButtonOnHover: true,
            hideProgressBar: true,
            closeButton: "button",
            icon: "fas fa-rocket",
            rtl: false
          });

          currentObj.profileData = response.data.profile;
          console.log("datos guardados");
        })
        .catch(function(error) {
          currentObj.output = error;
        });
    },
    fileSelected(e) {
      e.preventDefault();
      var files = e.target.files || e.dataTransfer.files;
      this.tempImages = files;
      if (!files.length) return;
      this.profileData.images = files;
    },

    createImage(file, index) {
      let currentObj = this;
      const config = {
        headers: { "content-type": "multipart/form-data" }
      };

      let formData = new FormData();
      formData.append("image", file);

      axios
        .post("/api/profile/upload", formData, config)
        .then(function(response) {
          currentObj.success = response.data.success;
        })
        .catch(function(error) {
          currentObj.output = error;
        });
    },

    removeImage() {
      this.profile.image = "";
    },
    updatePosition(params) {
      this.profile.latitude = params.lat;
      this.profile.longitude = params.lng;
    },
    filterImages(images) {
      if (images) images = JSON.parse(images);
      return images;
    }
  }
};
</script>
