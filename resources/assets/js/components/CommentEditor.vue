<template>
  <div class="add-comment" ref="wrapper">
    <hr>
    <a href="javascript:void(0)" class="add-comment-show" v-if="!editing" @click="editing = true">添加评论</a>
    <form class="need-validation add-comment-area" v-if="editing">
      <div class="input-group">
        <textarea class="form-control" :class="{'is-invalid': errMsg}" rows="4" placeholder="请输入评论，至少10个字符~~" v-model="text" @blur="validComment"></textarea>
        <div class="invalid-feedback" v-if="errMsg">
          {{ errMsg }}
        </div>
      </div>
      <div>
        <button class="btn btn-primary add-comment-button" @click="commit">添加评论</button>
        <button class="btn btn-link" @click="editing=false">取消</button>
      </div>
    </form>
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
        committing: false,
        text: null,
        timerHandler: null,
        errMsg: null,
      };
    },
    methods: {
      commit: function () {
        if (this.committing || !this.validCommit(this.text)) return;

        this.committing = true;
        $.post({
          url: '/comments',
          data: {
            id: this.id,
            type: this.type,
            body: this.text
          },
          success: data => {
            this.committing = false;
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

      validComment: function () {
        if (!this.text || this.text.length < 10) {
          this.errMsg = '请输入至少10个字符';
          return false;
        }
        this.errMsg = null;
        return true;
      }
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

      > div:first-child {
        flex: 1;

        textarea {
          width: 100%;
        }
      }

      > div:last-child {
        text-align: center;
        width: 7rem;
        height: 2.3rem;
        margin: 0 0.5em;

        > button {
          width: 100%;
        }
      }
    }
  }
</style>