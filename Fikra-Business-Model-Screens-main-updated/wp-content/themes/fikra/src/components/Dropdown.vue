<template>
  <div class="dropdown">
    <button @click="toggle(parseInt(mid))" class="dropbtn" :class="mclass">
      {{ title }}
      <span
        ><img
          :src="_settings.tlink+'/src/assets/img/down-arrow.svg'"
          alt="test"
          class="mr-1"
          :class="[show ? 'rotate-180' : '']"
      /></span>
    </button>
    <div  class="dropdown-content" v-if="show_id == parseInt(mid) && show">
      <a v-for="ch_link in child" :href="ch_link.url">{{ ch_link.title}}</a>
     </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
const show = ref(false);
const show_id = ref(false);
const { mid ,title, child ,mclass} = defineProps({
  mid: { type: String   },
  title: { type: String   },
  child: { type: Array },
  mclass: { type: String },
});


function toggle(id) {
  if(show_id.value == id){
     show_id.value = null;
     show.value = false
  }else{
    show_id.value = id;
    show.value = true
  }

}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function (event) {
  if (!event.target.matches(".dropbtn")) {
    show.value = false;
    show_id.value = null;
  }
};
</script>



<style scoped>
.dropbtn {
  color: #1e1e1e;
  border: none;
  cursor: pointer;

  display: flex;
  align-items: center;
  justify-content: space-between;
  overflow-y: hidden;

  padding: 20px 0;
   padding: 20px 0;
  font-size: 17px;
  font-weight: 400;
}
.
.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  position: absolute;
  right: -10px;
  background-color: #fff;
  min-width: 220px;
  overflow: auto;
  border-radius: 20px;
  z-index: 110;
  border: 1px solid #1e1e1e25;
  overflow: hidden;
}

.dropdown-content a {
  color: #1e1e1e;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {
  color: #4882ae;
}

@media (max-width: 950px) {
  .dropbtn {
    margin-top: 20px;
  }
}
</style>
