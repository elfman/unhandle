<template>
  <div class="vote">
    <div class="up" :class="{ active: status === 'upvote' }" @click="upvote"><i class="fa fa-sort-up"></i></div>
    <div class="vote-count">{{ count }}</div>
    <div class="down" :class="{ active: status === 'downvote' }" @click="downvote"><i class="fa fa-sort-down"></i></div>
  </div>
</template>

<script>
  export default {
    props: {
      voteCount: Number,
      id: Number,
      type: String,
      voteStatus: String,
    },
    data() {
      return {
        count: this.voteCount,
        status: this.voteStatus,
      };
    },
    methods: {
      upvote: function () {
        $.post({
          url: `/${this.type}/${this.id}/upvote`,
          success: function (data) {
            if (data.code === 0) {
              const vote_change = data.vote_change;
              this.count += vote_change;
              if (vote_change > 0) {
                this.status = 'upvote';
              } else if (vote_change < 0) {
                this.status = 'notVote';
              }
            }
          }
        });
      },
      downvote: function () {

      }
    }
  }
</script>

<style lang="scss" scoped>
  .vote {
    text-align: center;
    color: rgb(106, 115, 124);
    font-size: 1.8rem;
    line-height: 1;

    .vote-count {
      position: relative;
      top: 0.8rem;
    }
    .up, .down {
      font-size: 3rem;
      line-height: 1rem;
      height: 1rem;
      cursor: pointer;
    }
  }
</style>