<template>
  <div class="wrapper">
    <div class="badge badge-success" v-if="accepted">已采纳</div>
    <div v-if="canAccept">
      <button class="btn btn-primary sm" @click="accept" v-if="!accepted">采纳</button>
      <button class="btn btn-primary btn-sm" @click="cancelAccept" v-if="accepted">取消采纳</button>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      id: Number,
      canAccept: Boolean,
      pageData: {
        type: Object,
        default: function () {
          return window.pageData
        },
      },
    },
    data() {
      return {
      };
    },
    methods: {
      accept: function () {
        $.ajax({
          url: `/answers/${this.id}/accept`,
          method: 'POST',
          success: data => {
            if (data.code === 0) {
              window.pageData.acceptedAnswer = this.id;
            }
          }
        });
      },
      cancelAccept: function () {
        $.ajax({
          url: `/answers/${this.id}/cancelAccept`,
          method: 'POST',
          success: data => {
            if (data.code === 0) {
              window.pageData.acceptedAnswer = null;
            }
          }
        });
      }
    },
    computed: {
      accepted: function () {
        return this.pageData.acceptedAnswer === this.id;
      }
    }
  }
</script>

<style lang="scss" scoped>
  .wrapper {
    margin-top: 0.8rem;
    text-align: center;

    > div:nth-child(2) {
      margin-top: 1rem;
    }
  }
</style>