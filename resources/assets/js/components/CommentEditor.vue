<template>
  <div class="add-comment" ref="wrapper">
    <hr>
    <a href="javascript:void(0)" class="add-comment-show" v-if="!editing" @click="editing=true">添加评论</a>
    <div class="add-comment-area" v-if="editing">
      <textarea rows="4" placeholder="请输入评论，至少15个字符~~" v-model="text"></textarea>
      <button class="btn btn-primary add-comment-button" @click="commit">添加评论</button>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      type: String,
      id: Number,
    },
    data() {
      return {
        editing: false,
        commiting: false,
        text: null,
      };
    },
    methods: {
      commit: function () {
        if (this.commiting) return;

        this.commiting = true;
        $.post({
          url: '/comments',
          data: {
            id: this.id,
            type: this.type,
            body: this.text
          },
          success: data => {
            this.commiting = false;
            if (data.code === 0) {
              this.text = null;
              this.editing = false;
              const comment = data.comment;

              $(this.$refs.wrapper).parents('.comments').find('>.list').append(`
                <div class="comment" id="comment${comment.id}">
                  <hr>
                  <span class="comment-text">${comment.body}</span>
                  -
                  <a class="comment-user" href="/users/${comment.user.id}">${comment.user.name}</a>
                  <span class="comment-time">${comment.time}</span>
                </div>
              `);
            }
          }
        });
      },
    }
  }
</script>

<style lang="scss" scoped>
  .add-comment {
    margin-top: 0.4rem;
    font-size: 0.85rem;

    hr {
      margin-bottom: 0.5rem;
    }

    .add-comment-area {
      display: flex;

      textarea {
        flex: 1;
      }

      button {
        width: 7rem;
        height: 2.3rem;
        margin: 0 0.5em;
      }
    }
  }
</style>