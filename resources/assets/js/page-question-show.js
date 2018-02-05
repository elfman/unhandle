/**
 * Created by luoxiongwen on 2018/2/3.
 */
import Vue from 'vue';

import Voter from './components/Voter.vue';
import CommentEditor from './components/CommentEditor.vue';
import AnswerAcceptor from './components/AnswerAcceptor.vue';

Vue.component('voter', Voter);
Vue.component('comment-editor', CommentEditor);
Vue.component('answer-acceptor', AnswerAcceptor);


$('voter, comment-editor, answer-acceptor').each(function (index, elem) {
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

$('.comment-remove').on('click', function () {
  const id = $(this).data('id');
  $.ajax({
    url: '/comments/' + id,
    method: 'POST',
    data: { _method: 'DELETE' },
    success: function (data) {
      if (data.code === 0) {
        $('#comment' + id).remove();
      }
    }
  })
});
