import Vue from 'vue';

Vue.filter('truncate', function(value, length = 200){
  if (!value) {return '';}
  return value.length > length ? value.substring(0, length) + '...' : value;
})
