<template>
  <div class="vote">
    <div ref="up" class="up" :class="{ active: status === 'upvote' }" @click="upvote">
      <div class="triangle"></div>
    </div>
    <div class="vote-count">{{ count }}</div>
    <div ref="down" class="down" :class="{ active: status === 'downvote' }" @click="downvote">
      <div class="triangle reverse"></div>
    </div>
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
      showTooltip(elem) {
        $(elem).tooltip({
          title: '你不能投票给自己',
          placement: 'right',
          trigger: 'manual',
        }).tooltip('show');
        setTimeout(() => {
          $(elem).tooltip('hide');
        }, 1400);
      },
      upvote: function () {
        $.post({
          url: `/${this.type}/${this.id}/upvote`,
          success: (data) => {
            if (data.code === 0) {
              const vote_change = data.vote_change;
              this.count += vote_change;
              if (vote_change > 0) {
                this.status = 'upvote';
              } else if (vote_change < 0) {
                this.status = 'notVote';
              }
            }
          },
          error: (xhr) => {
            if (xhr.status === 403) {
              this.showTooltip(this.$refs.up);
            }
          },
        });
      },
      downvote: function () {
        $.post({
          url: `/${this.type}/${this.id}/downvote`,
          success: (data) => {
            if (data.code === 0) {
              const vote_change = data.vote_change;
              this.count += vote_change;
              if (vote_change < 0) {
                this.status = 'downvote';
              } else if (vote_change > 0) {
                this.status = 'notVote';
              }
            }
          },
          error: (xhr) => {
            if (xhr.status === 403) {
              this.showTooltip(this.$refs.down);
            }
          },
        });
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
      position: relative;
      left: 1.38rem;
      top: 0.78rem;

      &.active .triangle {
        border-color: #007bff transparent transparent #007bff;
      }

      .triangle {
        width: 0;
        transform: rotate(45deg);
        border-width: 0.6rem;
        border-color: #6a737c transparent transparent #6a737c;
        border-style: solid;
        border-radius: 4px;

        &.reverse {
          transform: rotate(-135deg);
        }
      }
    }
  }
</style>