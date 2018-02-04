/**
 * Created by luoxiongwen on 2018/2/3.
 */
import Vue from 'vue';

import Voter from './components/Voter.vue';

Vue.component('voter', Voter);

$('voter').each(function (index, elem) {
  new Vue({ el: elem });
});

$('.remove-question').on('click', function () {
  const id = $(this).parents('.question').data('id');
  $.ajax({
    url: '/questions/' + id,
    method: 'POST',
    data: { _method: 'DELETE' },
    success: function (data) {
      if (!data.code) {
        window.location.replace('/');
      }
    }
  });
});

$('.remove-answer').on('click', function () {
  const id = $(this).parents('.answer').data('id');
  $.ajax({
    url: '/answers/' + id,
    method: 'POST',
    data: { _method: 'DELETE' },
    success: function (data) {
      if (!data.code) {
        $('#answer' + id).remove();
      }
    }
  });
});