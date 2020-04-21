<template>
<div class="col-sm-12 input-group input-group-sm  ">

  <input type="text" class="form-control" placeholder="termino de busqueda" aria-label="Recipient's username" aria-describedby="button-addon2">

    <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="fa fa-search-location"></i>Buscar</button>
  </div>
</div>
</template>

<script>
    export default {
       props:  ['categories']
    }
</script>
