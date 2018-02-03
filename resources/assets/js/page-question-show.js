/**
 * Created by luoxiongwen on 2018/2/3.
 */
import Vue from 'vue';

import Voter from './components/Voter.vue';

Vue.component('voter', Voter);

$('voter').each(function (index, elem) {
  new Vue({ el: elem });
});